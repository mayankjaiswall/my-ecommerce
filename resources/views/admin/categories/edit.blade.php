@extends('layouts.admin')

@section('page-title', 'Edit Category')
@section('page-subtitle', 'Update details for ' . $category->category_name)

@section('content')

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">{{ $errors->first() }}</div>
    @endif

    <div class="admin-profile-header">
        <div>
            <div class="admin-profile-header__name">{{ $category->category_name }}</div>
            <div class="admin-profile-header__role">
                @if ($category->is_active)
                    <span class="admin-badge admin-badge--active">Active</span>
                @else
                    <span class="admin-badge admin-badge--inactive">Inactive</span>
                @endif
            </div>
        </div>
    </div>

    <div class="admin-panel">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Category Details</h3>
                <p class="admin-panel__subtitle">Edit the name, slug, and description</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="admin-form" id="categoryForm">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="admin-form-row">
                    <label for="category_name" class="admin-form-label">Category Name</label>
                    <input type="text" id="category_name" name="category_name" class="admin-form-input @error('category_name') is-invalid @enderror"
                        value="{{ old('category_name', $category->category_name) }}" required autocomplete="off">
                    @error('category_name')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="slug" class="admin-form-label">Slug</label>
                    <input type="text" id="slug" name="slug" class="admin-form-input @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $category->slug) }}" autocomplete="off">
                    <span class="admin-form-hint">Used in the category URL. Leave as-is or edit manually.</span>
                    @error('slug')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="admin-form-row">
                <label for="description" class="admin-form-label">Description</label>
                <textarea id="description" name="description" rows="8" class="admin-form-input @error('description') is-invalid @enderror"
                    placeholder="Optional short description shown on the storefront">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-actions admin-form-actions--split">
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn--outline">Cancel</a>
                <button type="submit" class="admin-btn admin-btn--primary">Save Changes</button>
            </div>
        </form>
    </div>

    <div class="admin-panel" style="margin-top: 20px;">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Category Status</h3>
                <p class="admin-panel__subtitle">Control visibility on the storefront</p>
            </div>
        </div>

        <div class="admin-status-actions">
            <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="admin-btn admin-btn--outline">
                    {{ $category->is_active ? 'Deactivate Category' : 'Activate Category' }}
                </button>
            </form>

            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                onsubmit="return confirm('Delete {{ $category->category_name }}? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn--danger">Delete Category</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            var nameInput = document.getElementById('category_name');
            var slugInput = document.getElementById('slug');
            var slugEditedManually = true;

            function slugify(value) {
                return value
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }

            slugInput.addEventListener('input', function () {
                slugEditedManually = true;
            });

            nameInput.addEventListener('input', function () {
                if (!slugEditedManually) {
                    slugInput.value = slugify(nameInput.value);
                }
            });
        })();
    </script>
@endpush
