<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->with(['tags' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('name')])
            ->orderBy('category_name')
            ->get()
            ->map(fn (Category $category) => $this->categoryData($category, true));

        return response()->json([
            'success' => true,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'tags' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('name'),
                'products' => fn ($query) => $query
                    ->where('is_active', true)
                    ->with('images')
                    ->orderBy('name'),
            ])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'category' => $this->categoryData($category, true),
        ]);
    }

    private function categoryData(Category $category, bool $includeRelations = false): array
    {
        $data = [
            'id' => $category->id,
            'category_name' => $category->category_name,
            'slug' => $category->slug,
            'description' => $category->description,
            'image_url' => $category->image_url,
        ];

        if ($includeRelations) {
            $data['tags'] = $category->tags->map(fn ($tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
            ])->values();
        }

        if ($category->relationLoaded('products')) {
            $data['products'] = $category->products->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'compare_price' => $product->compare_price,
                'stock_quantity' => $product->stock_quantity,
                'stock_status' => $product->stock_status,
                'image_url' => $product->image_url,
                'images' => $product->images->map(fn ($image) => [
                    'id' => $image->id,
                    'image_url' => $image->image_url,
                ])->values(),
            ])->values();
        }

        return $data;
    }
}