<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ModelList;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index(Request $request)
    {
        $brandId = $request->query('brand_id', 0);
        $typeId = $request->query('type_id', 0);

        $brandName = null;
        $typeName = null;

        if ($brandId > 0) {
            $brand = Brand::find($brandId);
            $brandName = $brand ? $brand->brand_name : null;
        }

        if ($typeId > 0) {
            $type = Brand::find($typeId);
            $typeName = $type ? $type->type_name : null;
        }

        $query = ModelList::with(['type', 'brand', 'specification'])
            ->orderBy('model_name', 'asc');

        if ($brandId > 0) {
            $query->where('brand_id', $brandId);
        }

        if ($typeId > 0) {
            $query->where('type_id', $typeId);
        }

        $models = $query->get();

        return view('models.index', compact(
            'models',
            'brandName',
            'brandId',
            'typeId'
        ));
    }

    public function show($id)
    {
        $model = ModelList::with([
            'brand',
            'type',
            'specification',
            'comments.user'
        ])->findOrFail($id);

        return view('models.show', compact('model'));
    }
}
