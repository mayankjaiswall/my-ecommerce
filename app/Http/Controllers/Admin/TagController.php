<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        return view('admin.tags.index', [
            'tags' => Tag::with('category')->latest()->get(),
            'categories' => Category::orderBy('category_name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.tags.create', [
            'categories' => Category::orderBy('category_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:tags,slug'],
        ]);

        Tag::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $validated['slug'] !== null && $validated['slug'] !== ''
                ? $validated['slug']
                : Tag::uniqueSlug($validated['name']),
            'is_active' => true,
        ]);

        return redirect()->route('admin.tags.index')->with('status', 'tag-created');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', [
            'tag' => $tag,
            'categories' => Category::orderBy('category_name')->get(),
        ]);
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('tags', 'slug')->ignore($tag->id)],
        ]);

        $tag->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $validated['slug'] !== null && $validated['slug'] !== ''
                ? $validated['slug']
                : Tag::uniqueSlug($validated['name'], $tag->id),
        ]);

        return redirect()->route('admin.tags.index')->with('status', 'tag-updated');
    }

    public function toggleStatus(Tag $tag): RedirectResponse
    {
        $tag->update(['is_active' => ! $tag->is_active]);

        return back()->with('status', $tag->is_active ? 'tag-activated' : 'tag-deactivated');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('status', 'tag-deleted');
    }
}
