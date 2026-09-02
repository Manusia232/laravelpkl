<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\ModelList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminTypeController extends Controller
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

        $types = Type::withCount('models')
            ->when($search, function ($query, $search) {
                return $query->where('type_name', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.types.index', compact('types', 'search'));
    }

    public function create()
    {
        return view('admin.types.form', [
            'type' => null,
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:100|unique:types,type_name',
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

        Type::create([
            'type_name' => $request->type_name,
            'url_photo' => $photoUrl
        ]);

        return redirect()
            ->route('admin.types.index')
            ->with('success', 'Tipe berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);

        return view('admin.types.form', [
            'type' => $type,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $type = Type::findOrFail($id);

        $request->validate([
            'type_name' => 'required|string|max:100|unique:types,type_name,' . $id,
            'foto' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $data = ['type_name' => $request->type_name];

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

        $type->update($data);

        return redirect()
            ->route('admin.types.index')
            ->with('success', 'Tipe berhasil diupdate!');
    }

    public function destroy($id)
    {
        $type = Type::findOrFail($id);

        // Cek apakah tipe masih digunakan di models
        $modelCount = ModelList::where('type_id', $id)->count();

        if ($modelCount > 0) {
            return redirect()
                ->route('admin.types.index')
                ->with('error', 'Tipe tidak dapat dihapus karena masih digunakan oleh ' . $modelCount . ' model kendaraan!');
        }

        $type->delete();

        return redirect()
            ->route('admin.types.index')
            ->with('success', 'Tipe berhasil dihapus!');
    }

    /**
     * Upload foto ke API eksternal.
     */
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

            if (
                isset($result['success']) &&
                $result['success'] === true &&
                isset($result['foto'])
            ) {
                return $result['foto'];
            }

            return null;

        } catch (\Exception $e) {
            return null;
        }
    }
}
