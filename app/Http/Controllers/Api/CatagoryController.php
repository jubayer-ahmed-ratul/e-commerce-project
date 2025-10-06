<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Catagories;
use Illuminate\Http\Request;

class CatagoryController extends Controller
{
    public function index(){
        $catagories = Catagories::where('visibility', 1)->get();

        if ($catagories->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No visible catagories found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Visible catagories retrieved successfully.',
            'data' => $catagories
        ], 200);
    }
    public function show($slug){
        $c = Catagories::where('slug', $slug)->where('visibility', 1)->first();

        if (!$c) {
            return response()->json([
                'success' => false,
                'message' => 'No visible catagory found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Visible catagory retrieved successfully.',
            'data' => $c
        ], 200);
    }
}
