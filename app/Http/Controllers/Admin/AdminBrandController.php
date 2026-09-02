<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminBrandController extends Controller
{
    protected $uploadApiUrl = 'https://43.106.115.184.nip.io/9/upload';

    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $brands = Brand::when($search, function ($query, $search) {
                return $query->where(
                    'brand_name',
                    'LIKE',
                    "%{$search}%"
                );
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.brands.index', compact('brands', 'search'));
    }

    public function create()
    {
        return view('admin.brands.form', [
            'brand' => null,
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:100|unique:brands,brand_name',
            'logo' => 'required|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $logoUrl = $this->uploadLogo($request->file('logo'));

        if (!$logoUrl) {
            return back()
                ->withErrors([
                    'logo' => 'Gagal mengupload logo.'
                ])
                ->withInput();
        }

        Brand::create([
            'brand_name' => $request->brand_name,
            'url_logo' => $logoUrl
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brands.form', [
            'brand' => $brand,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'brand_name' => 'required|string|max:100|unique:brands,brand_name,' . $id,
            'logo' => 'nullable|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $data = [
            'brand_name' => $request->brand_name
        ];

        // Jika user upload logo baru
        if ($request->hasFile('logo')) {
            $logoUrl = $this->uploadLogo($request->file('logo'));

            if ($logoUrl) {
                $data['url_logo'] = $logoUrl;
            } else {
                return back()
                    ->withErrors([
                        'logo' => 'Gagal mengupload logo baru.'
                    ])
                    ->withInput();
            }
        }

        $brand->update($data);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand berhasil diupdate!');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand berhasil dihapus!');
    }

    /**
     * Upload logo ke API eksternal.
     */
    private function uploadLogo($file)
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
