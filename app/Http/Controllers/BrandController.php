<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('models')
            ->orderBy('brand_name', 'asc')
            ->get();

        return view('brands.index', compact('brands'));
    }
}
