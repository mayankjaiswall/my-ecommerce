<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::with(['category', 'tag'])->latest()->get(),
            'categories' => Category::orderBy('category_name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::orderBy('category_name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'tag_id' => $validated['tag_id'] ?? null,
            'name' => $validated['name'],
            'slug' => ! empty($validated['slug'])
                ? $validated['slug']
                : Product::uniqueSlug($validated['name']),
            'sku' => $validated['sku'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'compare_price' => $validated['compare_price'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'low_stock_threshold' => $validated['low_stock_threshold'],
            'image' => $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null,
            'is_active' => true,
        ]);

        $this->storeGalleryImages($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'product-created');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product->load('images'),
            'categories' => Category::orderBy('category_name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $imagePath = null;
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'tag_id' => $validated['tag_id'] ?? null,
            'name' => $validated['name'],
            'slug' => ! empty($validated['slug'])
                ? $validated['slug']
                : Product::uniqueSlug($validated['name'], $product->id),
            'sku' => $validated['sku'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'compare_price' => $validated['compare_price'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'low_stock_threshold' => $validated['low_stock_threshold'],
            'image' => $imagePath,
        ]);

        if ($request->filled('remove_gallery_images')) {
            ProductImage::whereIn('id', $request->input('remove_gallery_images'))
                ->where('product_id', $product->id)
                ->get()
                ->each(function (ProductImage $image) {
                    Storage::disk('public')->delete($image->image);
                    $image->delete();
                });
        }

        $this->storeGalleryImages($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'product-updated');
    }

    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('status', $product->is_active ? 'product-activated' : 'product-deactivated');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->images->each(fn (ProductImage $image) => Storage::disk('public')->delete($image->image));

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'product-deleted');
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'tag_id' => ['nullable', 'exists:tags,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('products', 'slug')->ignore($product?->id)],
            'sku' => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product?->id)],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_gallery_images' => ['nullable', 'array'],
            'remove_gallery_images.*' => ['integer', 'exists:product_images,id'],
        ]);
    }

    private function storeGalleryImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('gallery_images')) {
            return;
        }

        $nextSortOrder = (int) $product->images()->max('sort_order') + 1;

        foreach ($request->file('gallery_images') as $file) {
            $product->images()->create([
                'image' => $file->store('products/gallery', 'public'),
                'sort_order' => $nextSortOrder++,
            ]);
        }
    }
}
