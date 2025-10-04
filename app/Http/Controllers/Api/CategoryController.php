<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get all visible categories
     */
    public function index()
    {
        $categories = Category::where('visibility', 1)->get();

        if ($categories->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No visible categories found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Visible categories retrieved successfully.',
            'data' => $categories
        ], 200);
    }

    /**
     * Get a single category by slug
     */
    public function showBySlug($slug)
    {
        $category = Category::where('slug', $slug)
                            ->where('visibility', 1)
                            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found or is not visible.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Category retrieved successfully.',
            'data' => $category
        ], 200);
    }
}
