@extends('layouts.admin')

@section('page-title', 'Add Category')
@section('page-subtitle', 'Create a new storefront category')

@section('content')

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">{{ $errors->first() }}</div>
    @endif

    <div class="admin-panel">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Category Details</h3>
                <p class="admin-panel__subtitle">Name, slug, and description</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="admin-form">
            @csrf

            <div class="admin-form-grid">
                <div class="admin-form-row">
                    <label for="category_name" class="admin-form-label">Category Name</label>
                    <input type="text" id="category_name" name="category_name" class="admin-form-input @error('category_name') is-invalid @enderror"
                        value="{{ old('category_name') }}" required autocomplete="off" autofocus>
                    @error('category_name')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="slug" class="admin-form-label">Slug</label>
                    <input type="text" id="slug" name="slug" class="admin-form-input @error('slug') is-invalid @enderror"
                        value="{{ old('slug') }}" placeholder="auto-generated-from-name" autocomplete="off">
                    <span class="admin-form-hint">Used in the category URL. Leave blank to auto-generate from the name.</span>
                    @error('slug')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="admin-form-row">
                <label for="description" class="admin-form-label">Description</label>
                <textarea id="description" name="description" rows="8" class="admin-form-input @error('description') is-invalid @enderror"
                    placeholder="Optional short description shown on the storefront">{{ old('description') }}</textarea>
                @error('description')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-actions admin-form-actions--split">
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn--outline">Cancel</a>
                <button type="submit" class="admin-btn admin-btn--primary">Create Category</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            var nameInput = document.getElementById('category_name');
            var slugInput = document.getElementById('slug');
            var slugEditedManually = slugInput.value !== '';

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
