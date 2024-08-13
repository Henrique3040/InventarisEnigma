<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);
    
            $category = Category::create([
                'name' => $validated['name'],
            ]);
    
            return response()->json($category, 201);
        } catch (\Exception $e) {
            \Log::error('Category creation error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
