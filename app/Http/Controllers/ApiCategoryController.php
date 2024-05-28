<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        return response()->json([
            'categories' => Category::where('parent_id', '=', $request->parent_id)->get()
        ]);
    }
}
