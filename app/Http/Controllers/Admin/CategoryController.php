<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create([
            'category_name' => $validated['category_name'],
            'slug' => $validated['slug'] !== null && $validated['slug'] !== ''
                ? $validated['slug']
                : Category::uniqueSlug($validated['category_name']),
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'category-created');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('categories', 'slug')->ignore($category->id)],
            'description' => ['nullable', 'string'],
        ]);

        $category->update([
            'category_name' => $validated['category_name'],
            'slug' => $validated['slug'] !== null && $validated['slug'] !== ''
                ? $validated['slug']
                : Category::uniqueSlug($validated['category_name'], $category->id),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')->with('status', 'category-updated');
    }

    public function toggleStatus(Category $category): RedirectResponse
    {
        $category->update(['is_active' => ! $category->is_active]);

        return back()->with('status', $category->is_active ? 'category-activated' : 'category-deactivated');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'category-deleted');
    }
}
