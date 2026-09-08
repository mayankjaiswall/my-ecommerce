@extends('layouts.admin')

@section('page-title', 'Edit Tag')
@section('page-subtitle', 'Update details for ' . $tag->name)

@section('content')

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">{{ $errors->first() }}</div>
    @endif

    <div class="admin-profile-header">
        <div>
            <div class="admin-profile-header__name">{{ $tag->name }}</div>
            <div class="admin-profile-header__role">
                @if ($tag->is_active)
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
                <h3 class="admin-panel__title">Tag Details</h3>
                <p class="admin-panel__subtitle">Edit the category, name, and slug</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.tags.update', $tag) }}" class="admin-form" id="tagForm">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="admin-form-row">
                    <label for="category_id" class="admin-form-label">Category</label>
                    <select id="category_id" name="category_id" class="admin-form-input @error('category_id') is-invalid @enderror" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) old('category_id', $tag->category_id) === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="name" class="admin-form-label">Tag Name</label>
                    <input type="text" id="name" name="name" class="admin-form-input @error('name') is-invalid @enderror"
                        value="{{ old('name', $tag->name) }}" required autocomplete="off">
                    @error('name')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="admin-form-row">
                <label for="slug" class="admin-form-label">Slug</label>
                <input type="text" id="slug" name="slug" class="admin-form-input @error('slug') is-invalid @enderror"
                    value="{{ old('slug', $tag->slug) }}" autocomplete="off">
                <span class="admin-form-hint">Used in filter URLs. Leave as-is or edit manually.</span>
                @error('slug')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="admin-form-actions admin-form-actions--split">
                <a href="{{ route('admin.tags.index') }}" class="admin-btn admin-btn--outline">Cancel</a>
                <button type="submit" class="admin-btn admin-btn--primary">Save Changes</button>
            </div>
        </form>
    </div>

    <div class="admin-panel" style="margin-top: 20px;">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Tag Status</h3>
                <p class="admin-panel__subtitle">Control visibility on the shop page</p>
            </div>
        </div>

        <div class="admin-status-actions">
            <form method="POST" action="{{ route('admin.tags.toggle-status', $tag) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="admin-btn admin-btn--outline">
                    {{ $tag->is_active ? 'Deactivate Tag' : 'Activate Tag' }}
                </button>
            </form>

            <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                onsubmit="return confirm('Delete {{ $tag->name }}? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn--danger">Delete Tag</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            var nameInput = document.getElementById('name');
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
