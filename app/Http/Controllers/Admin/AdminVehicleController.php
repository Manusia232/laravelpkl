<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModelList;
use App\Models\Brand;
use App\Models\Type;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AdminVehicleController extends Controller
{
    protected $uploadApiUrl = 'https://43.106.115.184.nip.io/9/upload';

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('role:admin');
    // }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $brandFilter = $request->query('brand', '');

        $query = ModelList::with(['brand', 'type', 'specification'])
            ->withCount('comments');

        if ($search) {
            $query->where('model_name', 'LIKE', "%{$search}%");
        }

        if ($brandFilter) {
            $query->where('brand_id', $brandFilter);
        }

        $vehicles = $query->orderBy('id', 'desc')->get();

        // Tambahkan status spesifikasi
        foreach ($vehicles as $vehicle) {
            $spec = $vehicle->specification;
            $isComplete = $spec &&
                !empty($spec->detail) &&
                !empty($spec->body) &&
                !empty($spec->performa) &&
                !empty($spec->kelistrikan) &&
                !empty($spec->keselamatan) &&
                !empty($spec->fiturlainya);
            $vehicle->status_spesifikasi = $isComplete ? 'Lengkap' : 'Belum Lengkap';
        }

        $brands = Brand::orderBy('brand_name')->get();
        $totalBrands = $brands->count();

        return view('admin.vehicles.index', compact('vehicles', 'search', 'brandFilter', 'brands', 'totalBrands'));
    }

    public function create()
    {
        $brands = Brand::orderBy('brand_name')->get();
        $types = Type::orderBy('type_name')->get();

        $specDefs = $this->getSpecDefinitions();

        return view('admin.vehicles.form', [
            'vehicle' => null,
            'isEdit' => false,
            'brands' => $brands,
            'types' => $types,
            'specDefs' => $specDefs,
            'basTags' => $this->getBasTags()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_name' => 'required|string|max:150',
            'brand_id' => 'required|exists:brands,id',
            'type_id' => 'nullable|exists:types,id',
            'foto' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $photoUrl = null;

        if ($request->hasFile('foto')) {
            $photoUrl = $this->uploadPhoto($request->file('foto'));
            if (!$photoUrl) {
                return back()
                    ->withErrors(['foto' => 'Gagal mengupload foto.'])
                    ->withInput();
            }
        }

        DB::beginTransaction();

        try {
            $model = ModelList::create([
                'brand_id' => $request->brand_id,
                'type_id' => $request->type_id ?: null,
                'model_name' => $request->model_name,
                'url_photo' => $photoUrl
            ]);

            $specData = $this->prepareSpecData($request);
            Specification::create(array_merge(
                ['model_id' => $model->id],
                $specData
            ));

            DB::commit();

            return redirect()
                ->route('admin.vehicles.index')
                ->with('success', 'Kendaraan berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $vehicle = ModelList::with('specification')->findOrFail($id);
        $brands = Brand::orderBy('brand_name')->get();
        $types = Type::orderBy('type_name')->get();

        $specDefs = $this->getSpecDefinitions();

        // Parse existing specs
        foreach ($specDefs as $fieldName => &$def) {
            // Ambil data dari specification
            $specData = $vehicle->specification ? $vehicle->specification->$fieldName : null;
            $def['rows'] = $this->parseSpecRows($specData, $def['default'], $def['list']);
        }

        return view('admin.vehicles.form', [
            'vehicle' => $vehicle,
            'isEdit' => true,
            'brands' => $brands,
            'types' => $types,
            'specDefs' => $specDefs,
            'basTags' => $this->getBasTags()
        ]);
    }

    public function update(Request $request, $id)
    {
        $vehicle = ModelList::findOrFail($id);

        $request->validate([
            'model_name' => 'required|string|max:150',
            'brand_id' => 'required|exists:brands,id',
            'type_id' => 'nullable|exists:types,id',
            'foto' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $data = [
            'brand_id' => $request->brand_id,
            'type_id' => $request->type_id ?: null,
            'model_name' => $request->model_name
        ];

        if ($request->hasFile('foto')) {
            $photoUrl = $this->uploadPhoto($request->file('foto'));
            if ($photoUrl) {
                $data['url_photo'] = $photoUrl;
            } else {
                return back()
                    ->withErrors(['foto' => 'Gagal mengupload foto baru.'])
                    ->withInput();
            }
        }

        DB::beginTransaction();

        try {
            $vehicle->update($data);

            $specData = $this->prepareSpecData($request);

            if ($vehicle->specification) {
                $vehicle->specification->update($specData);
            } else {
                Specification::create(array_merge(
                    ['model_id' => $vehicle->id],
                    $specData
                ));
            }

            DB::commit();

            return redirect()
                ->route('admin.vehicles.index')
                ->with('success', 'Kendaraan berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $vehicle = ModelList::findOrFail($id);
        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus!');
    }

    // ============== HELPER METHODS ==============

    private function uploadPhoto($file)
    {
        try {
            $response = Http::attach(
                'foto',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->post($this->uploadApiUrl);

            if (!$response->successful()) {
                return null;
            }

            $result = $response->json();

            if (isset($result['success']) && $result['success'] === true && isset($result['foto'])) {
                return $result['foto'];
            }

            return null;

        } catch (\Exception $e) {
            return null;
        }
    }

    private function getSpecDefinitions()
    {
        return [
            'detail' => [
                'label' => 'Detail Umum',
                'default' => ['brand', 'model', 'trim', 'model_year', 'market', 'price'],
                'list' => [],
            ],
            'body' => [
                'label' => 'Body & Eksterior',
                'default' => ['body_style', 'materials', 'jumlah_pintu', 'jumlah_kursi', 'panjang', 'lebar', 'tinggi', 'wheelbase', 'ground_clearance', 'trunk_volume', 'frunk_volume', 'ukuran_ban'],
                'list' => [],
            ],
            'performa' => [
                'label' => 'Performa',
                'default' => ['tipe_motor', 'power', 'torque', 'akselerasi_0_100', 'tipe_steering', 'drivetrain', 'suspensi_depan', 'suspensi_belakang', 'rem_depan', 'rem_belakang'],
                'list' => [],
            ],
            'kelistrikan' => [
                'label' => 'Kelistrikan',
                'default' => ['kapasitas_baterai', 'tipe_baterai', 'jarak_tempuh', 'efisiensi_energi', 'max_power_charging_dc', 'max_power_charging_ac', 'waktu_charging_dc_30_80', 'waktu_charging_ac'],
                'list' => [],
            ],
            'keselamatan' => [
                'label' => 'Keselamatan',
                'default' => ['fitur_keselamatan_bantuan'],
                'list' => ['fitur_keselamatan_bantuan'],
            ],
            'fiturlainya' => [
                'label' => 'Fitur Lainnya',
                'default' => ['infotainment_konektivitas', 'kursi', 'pintu_jendela', 'lampu', 'fitur_tambahan'],
                'list' => ['infotainment_konektivitas', 'kursi', 'pintu_jendela', 'lampu', 'fitur_tambahan'],
            ],
        ];
    }

    private function getBasTags()
    {
        $tags = [];
        for ($i = 1; $i <= 10; $i++) {
            $tags[] = 'bas' . $i;
        }
        return $tags;
    }

    /**
     * Parse spec rows dari data (bisa string JSON atau array)
     */
    private function parseSpecRows($data, $defaultKeys = [], $listKeys = [])
    {
        $rows = [];
        $decoded = null;

        // Jika data adalah string JSON, decode
        if (is_string($data) && $data !== '') {
            $decoded = json_decode($data, true);
        }
        // Jika data sudah berupa array
        elseif (is_array($data) && !empty($data)) {
            $decoded = $data;
        }

        if (is_array($decoded) && !empty($decoded)) {
            foreach ($decoded as $k => $v) {
                $isList = is_array($v);
                $valStr = $isList ? implode('; ', array_map('strval', $v)) : (string)$v;
                $bas = '';
                if (preg_match('/\(\s*(bas([1-9]|10))\s*\)/i', $valStr, $m)) {
                    $bas = strtolower($m[1]);
                }
                $rows[] = [
                    'key' => (string)$k,
                    'value' => $valStr,
                    'type' => $isList ? 'list' : 'text',
                    'bas' => $bas,
                ];
            }
        } else {
            // Gunakan default keys jika tidak ada data
            foreach ($defaultKeys as $dk) {
                $rows[] = [
                    'key' => $dk,
                    'value' => '',
                    'type' => in_array($dk, $listKeys, true) ? 'list' : 'text',
                    'bas' => '',
                ];
            }
        }

        return $rows;
    }

    private function prepareSpecData($request)
    {
        $fields = ['detail', 'body', 'performa', 'kelistrikan', 'keselamatan', 'fiturlainya'];
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $request->input($field, '');
        }

        return $data;
    }
}
