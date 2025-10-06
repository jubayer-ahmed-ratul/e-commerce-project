<?php

namespace App\Http\Controllers\Api;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
 // Get all visible brands
    public function index()
    {
        $brands = Brand::where('visibility', 1)->get();

        if ($brands->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No visible brands found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Visible brands retrieved successfully.',
            'data' => $brands
        ], 200);
    }

    // Get a single brand by ID
    public function show($id)
    {
        $brand = Brand::where('id', $id)
                      ->where('visibility', 1)
                      ->first();

        if (!$brand) {
            return response()->json([
                'success' => false,
                'message' => 'Brand not found or is not visible.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Brand retrieved successfully.',
            'data' => $brand,
            'products' => ''
        ], 200);
    }
}
