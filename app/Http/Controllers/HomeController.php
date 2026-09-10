<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('category_name')
            ->get();

        return view('index', [
            'categories' => $categories,
        ]);
    }
}