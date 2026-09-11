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

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="admin-form" id="categoryForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="admin-form-media-grid">
                <div class="admin-form-media-grid__fields">
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

                    <div class="admin-form-row">
                        <label for="description" class="admin-form-label">Description</label>
                        <textarea id="description" name="description" rows="6" class="admin-form-input @error('description') is-invalid @enderror"
                            placeholder="Optional short description shown on the storefront">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-row">
                    <label class="admin-form-label">Category Image</label>
                    <div class="admin-image-uploader">
                        <div class="admin-image-dropzone" id="categoryImageDropzone">
                            <span class="admin-image-dropzone-preview" id="categoryImagePreview">
                                @if ($category->image_url)
                                    <img src="{{ $category->image_url }}" alt="{{ $category->category_name }}">
                                @else
                                    <span class="admin-image-dropzone-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 8.25 12 3.75m0 0L7.5 8.25M12 3.75v12" />
                                        </svg>
                                        <span>Click to upload image</span>
                                    </span>
                                @endif
                            </span>
                            <input type="file" id="categoryImageInput" name="image" accept="image/png,image/jpeg,image/webp" class="admin-image-dropzone-input">
                        </div>
                        <span class="admin-form-hint">JPG, PNG or WEBP. Max 2MB.</span>
                        @error('image')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror

                        @if ($category->image)
                            <label class="admin-image-remove-check">
                                <input type="checkbox" name="remove_image" id="categoryImageRemove" value="1">
                                Remove current image
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <template id="categoryImagePlaceholderTemplate">
                <span class="admin-image-dropzone-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 8.25 12 3.75m0 0L7.5 8.25M12 3.75v12" />
                    </svg>
                    <span>Click to upload image</span>
                </span>
            </template>

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

        (function () {
            var input = document.getElementById('categoryImageInput');
            var preview = document.getElementById('categoryImagePreview');
            var removeCheckbox = document.getElementById('categoryImageRemove');
            var placeholderTemplate = document.getElementById('categoryImagePlaceholderTemplate');

            input.addEventListener('change', function () {
                var file = input.files && input.files[0];

                if (!file) {
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (event) {
                    preview.innerHTML = '<img src="' + event.target.result + '" alt="Preview">';
                };
                reader.readAsDataURL(file);

                if (removeCheckbox) {
                    removeCheckbox.checked = false;
                }
            });

            if (removeCheckbox) {
                removeCheckbox.addEventListener('change', function () {
                    if (removeCheckbox.checked) {
                        input.value = '';
                        preview.innerHTML = placeholderTemplate.innerHTML;
                    }
                });
            }
        })();
    </script>
@endpush
