<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        $tags = Tag::query()
            ->where('is_active', true)
            ->whereHas('category', fn ($query) => $query->where('is_active', true))
            ->with(['category'])
            ->orderBy('name')
            ->get()
            ->map(fn (Tag $tag) => $this->tagData($tag));

        return response()->json([
            'success' => true,
            'tags' => $tags,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $tag = Tag::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->whereHas('category', fn ($query) => $query->where('is_active', true))
            ->with([
                'category',
                'products' => fn ($query) => $query
                    ->where('is_active', true)
                    ->with('images')
                    ->orderBy('name'),
            ])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'tag' => $this->tagData($tag, true),
        ]);
    }

    private function tagData(Tag $tag, bool $includeProducts = false): array
    {
        $data = [
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
            'category' => [
                'id' => $tag->category->id,
                'category_name' => $tag->category->category_name,
                'slug' => $tag->category->slug,
            ],
        ];

        if ($includeProducts) {
            $data['products'] = $tag->products->map(fn ($product) => [
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