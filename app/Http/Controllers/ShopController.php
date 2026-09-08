<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->with(['tags' => fn ($query) => $query->where('is_active', true)->orderBy('name')])
            ->orderBy('category_name')
            ->get();

        return view('shop', [
            'categories' => $categories,
        ]);
    }
}
