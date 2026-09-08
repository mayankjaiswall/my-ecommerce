@extends('layouts.admin')

@section('page-title', 'Add Tag')
@section('page-subtitle', 'Create a new attribute filter for a category')

@section('content')

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">{{ $errors->first() }}</div>
    @endif

    <div class="admin-panel">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Tag Details</h3>
                <p class="admin-panel__subtitle">Category, name, and slug</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.tags.store') }}" class="admin-form">
            @csrf

            <div class="admin-form-grid">
                <div class="admin-form-row">
                    <label for="category_id" class="admin-form-label">Category</label>
                    <select id="category_id" name="category_id" class="admin-form-input @error('category_id') is-invalid @enderror" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="admin-form-hint">This tag will appear under this category on the shop page.</span>
                    @error('category_id')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="name" class="admin-form-label">Tag Name</label>
                    <input type="text" id="name" name="name" class="admin-form-input @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="e.g. Full Sleeve" required autocomplete="off" autofocus>
                    @error('name')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="admin-form-row">
                <label for="slug" class="admin-form-label">Slug</label>
                <input type="text" id="slug" name="slug" class="admin-form-input @error('slug') is-invalid @enderror"
                    value="{{ old('slug') }}" placeholder="auto-generated-from-name" autocomplete="off">
                <span class="admin-form-hint">Used in filter URLs. Leave blank to auto-generate from the name.</span>
                @error('slug')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-actions admin-form-actions--split">
                <a href="{{ route('admin.tags.index') }}" class="admin-btn admin-btn--outline">Cancel</a>
                <button type="submit" class="admin-btn admin-btn--primary">Create Tag</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            var nameInput = document.getElementById('name');
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
