<?php

namespace App\Http\Controllers;

use App\Models\ModelList;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil data dari session compare
        $compareIds = session('compare', []);
        $selectedModels = [];

        if (!empty($compareIds)) {
            $selectedModels = ModelList::with(['brand', 'type', 'specification'])
                ->whereIn('id', $compareIds)
                ->get()
                ->keyBy('id');

            // Urutkan sesuai urutan di session
            $orderedModels = [];
            foreach ($compareIds as $id) {
                if (isset($selectedModels[$id])) {
                    $orderedModels[] = $selectedModels[$id];
                }
            }
            $selectedModels = $orderedModels;
        }

        // Ambil statistik
        $totalModels = ModelList::count();
        $totalBrands = Brand::count();
        $totalCategories = \App\Models\Type::count();

        // Ambil kategori untuk ditampilkan
        $categories = \App\Models\Type::withCount('models')
            ->orderBy('type_name')
            ->get();

        return view('landing.index', compact(
            'selectedModels', 
            'totalModels', 
            'totalBrands', 
            'totalCategories',
            'categories'
        ));
    }

    public function searchModels(Request $request)
    {
        $query = $request->query('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $models = ModelList::with(['brand', 'type'])
            ->where('model_name', 'LIKE', "%{$query}%")
            ->orWhereHas('brand', function($q) use ($query) {
                $q->where('brand_name', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get()
            ->map(function($model) {
                return [
                    'id' => $model->id,
                    'name' => $model->model_name,
                    'brand' => $model->brand->brand_name ?? '',
                    'type' => $model->type->type_name ?? '',
                    'url_photo' => $model->url_photo,
                ];
            });

        return response()->json($models);
    }

    public function addToCompare(Request $request)
    {
        $id = $request->input('id');
        
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'ID kendaraan tidak ditemukan.'
            ], 400);
        }

        $compareIds = session('compare', []);
        
        // Cek apakah model ada
        $model = ModelList::find($id);
        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak ditemukan.'
            ], 404);
        }

        // Cek apakah sudah ada
        if (in_array($id, $compareIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan sudah ada di daftar perbandingan.'
            ], 400);
        }

        // Cek batas maksimal
        if (count($compareIds) >= 4) {
            return response()->json([
                'success' => false,
                'message' => 'Maksimal 4 kendaraan dapat dibandingkan.'
            ], 400);
        }

        $compareIds[] = $id;
        session(['compare' => $compareIds]);

        // Ambil data model yang baru ditambahkan
        $modelData = [
            'id' => $model->id,
            'model_name' => $model->model_name,
            'brand_name' => $model->brand->brand_name ?? '',
            'url_photo' => $model->url_photo,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil ditambahkan ke perbandingan.',
            'model' => $modelData,
            'count' => count($compareIds)
        ]);
    }

    public function removeFromCompare(Request $request)
    {
        $id = $request->input('id');
        
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'ID kendaraan tidak ditemukan.'
            ], 400);
        }

        $compareIds = session('compare', []);
        
        if (($key = array_search($id, $compareIds)) !== false) {
            unset($compareIds[$key]);
            session(['compare' => array_values($compareIds)]);
            
            return response()->json([
                'success' => true,
                'message' => 'Kendaraan dihapus dari daftar perbandingan.',
                'count' => count($compareIds)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Kendaraan tidak ditemukan dalam daftar perbandingan.'
        ], 404);
    }
}