@extends('layouts.admin')

@section('page-title', 'Edit Product')
@section('page-subtitle', 'Update details for ' . $product->name)

@section('content')

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">{{ $errors->first() }}</div>
    @endif

    <div class="admin-profile-header">
        <div>
            <div class="admin-profile-header__name">{{ $product->name }}</div>
            <div class="admin-profile-header__role" style="display: flex; gap: 6px; flex-wrap: wrap;">
                @if ($product->is_active)
                    <span class="admin-badge admin-badge--active">Active</span>
                @else
                    <span class="admin-badge admin-badge--inactive">Inactive</span>
                @endif

                @if ($product->stock_status === 'out_of_stock')
                    <span class="admin-badge admin-badge--danger">Out of Stock</span>
                @elseif ($product->stock_status === 'low_stock')
                    <span class="admin-badge admin-badge--warning">Low Stock</span>
                @else
                    <span class="admin-badge admin-badge--active">In Stock</span>
                @endif
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" class="admin-form" id="productForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="admin-panel">
            <div class="admin-panel__header">
                <div>
                    <h3 class="admin-panel__title">Product Details</h3>
                    <p class="admin-panel__subtitle">Category, name, SKU, and description</p>
                </div>
            </div>

            <div class="admin-form-media-grid">
                <div class="admin-form-media-grid__fields">
                    <div class="admin-form-grid">
                        <div class="admin-form-row">
                            <label for="category_id" class="admin-form-label">Category</label>
                            <select id="category_id" name="category_id" class="admin-form-input @error('category_id') is-invalid @enderror" required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('category_id', $product->category_id) === (string) $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form-row">
                            <label for="tag_id" class="admin-form-label">Sub-category (Tag)</label>
                            <select id="tag_id" name="tag_id" class="admin-form-input @error('tag_id') is-invalid @enderror">
                                <option value="">No sub-category</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" data-category="{{ $tag->category_id }}"
                                        {{ (string) old('tag_id', $product->tag_id) === (string) $tag->id ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="admin-form-hint">Options are filtered to match the selected category.</span>
                            @error('tag_id')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <label for="name" class="admin-form-label">Product Name</label>
                        <input type="text" id="name" name="name" class="admin-form-input @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}" required autocomplete="off">
                        @error('name')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-form-grid">
                        <div class="admin-form-row">
                            <label for="sku" class="admin-form-label">SKU</label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="sku" name="sku" class="admin-form-input @error('sku') is-invalid @enderror"
                                    value="{{ old('sku', $product->sku) }}" required autocomplete="off" style="flex: 1;">
                                <button type="button" id="generateSkuBtn" class="admin-btn admin-btn--outline admin-btn--sm" style="white-space: nowrap;">Generate</button>
                            </div>
                            @error('sku')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form-row">
                            <label for="slug" class="admin-form-label">Slug</label>
                            <input type="text" id="slug" name="slug" class="admin-form-input @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $product->slug) }}" autocomplete="off">
                            @error('slug')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <label for="description" class="admin-form-label">Description</label>
                        <textarea id="description" name="description" rows="5" class="admin-form-input @error('description') is-invalid @enderror"
                            placeholder="Optional product description shown on the storefront">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-row">
                    <label class="admin-form-label">Main Image</label>
                    <div class="admin-image-uploader">
                        <div class="admin-image-dropzone" id="productImageDropzone">
                            <span class="admin-image-dropzone-preview" id="productImagePreview">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @else
                                    <span class="admin-image-dropzone-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 8.25 12 3.75m0 0L7.5 8.25M12 3.75v12" />
                                        </svg>
                                        <span>Click to upload image</span>
                                    </span>
                                @endif
                            </span>
                            <input type="file" id="productImageInput" name="image" accept="image/png,image/jpeg,image/webp" class="admin-image-dropzone-input">
                        </div>
                        <span class="admin-form-hint">JPG, PNG or WEBP. Max 2MB.</span>
                        @error('image')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror

                        @if ($product->image)
                            <label class="admin-image-remove-check">
                                <input type="checkbox" name="remove_image" id="productImageRemove" value="1">
                                Remove current image
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <template id="productImagePlaceholderTemplate">
                <span class="admin-image-dropzone-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 8.25 12 3.75m0 0L7.5 8.25M12 3.75v12" />
                    </svg>
                    <span>Click to upload image</span>
                </span>
            </template>
        </div>

        <div class="admin-panel" style="margin-top: 20px;">
            <div class="admin-panel__header">
                <div>
                    <h3 class="admin-panel__title">Pricing &amp; Stock</h3>
                    <p class="admin-panel__subtitle">Set the selling price and track available inventory</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-form-row">
                    <label for="price" class="admin-form-label">Price ($)</label>
                    <input type="number" step="0.01" min="0" id="price" name="price" class="admin-form-input @error('price') is-invalid @enderror"
                        value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="compare_price" class="admin-form-label">Compare-at Price ($)</label>
                    <input type="number" step="0.01" min="0" id="compare_price" name="compare_price" class="admin-form-input @error('compare_price') is-invalid @enderror"
                        value="{{ old('compare_price', $product->compare_price) }}" placeholder="Optional">
                    <span class="admin-form-hint">Must be higher than price to show a strikethrough discount.</span>
                    @error('compare_price')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-form-row">
                    <label for="stock_quantity" class="admin-form-label">Stock Quantity</label>
                    <input type="number" step="1" min="0" id="stock_quantity" name="stock_quantity" class="admin-form-input @error('stock_quantity') is-invalid @enderror"
                        value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                    @error('stock_quantity')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="admin-form-row">
                    <label for="low_stock_threshold" class="admin-form-label">Low Stock Threshold</label>
                    <input type="number" step="1" min="0" id="low_stock_threshold" name="low_stock_threshold" class="admin-form-input @error('low_stock_threshold') is-invalid @enderror"
                        value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" required>
                    <span class="admin-form-hint">Flagged as "Low Stock" at or below this quantity.</span>
                    @error('low_stock_threshold')
                        <span class="admin-form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="admin-panel" style="margin-top: 20px;">
            <div class="admin-panel__header">
                <div>
                    <h3 class="admin-panel__title">Gallery Images</h3>
                    <p class="admin-panel__subtitle">Additional product photos shown on the storefront</p>
                </div>
            </div>

            <div class="admin-gallery-uploader">
                <div class="admin-gallery-grid" id="galleryGrid">
                    @foreach ($product->images as $image)
                        <div class="admin-gallery-item" data-existing-id="{{ $image->id }}">
                            <img src="{{ $image->image_url }}" alt="{{ $product->name }}">
                            <button type="button" class="admin-gallery-item__remove js-remove-existing-image" data-id="{{ $image->id }}" aria-label="Remove image">&times;</button>
                        </div>
                    @endforeach

                    <label class="admin-gallery-add" id="galleryAddTile">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Add Images</span>
                        <input type="file" id="galleryInput" name="gallery_images[]" accept="image/png,image/jpeg,image/webp" multiple>
                    </label>
                </div>
                <div id="removeGalleryInputs"></div>
                <span class="admin-form-hint">JPG, PNG or WEBP. You can select multiple images.</span>
                @error('gallery_images.*')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="admin-form-actions admin-form-actions--split" style="margin-top: 20px;">
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn--outline">Cancel</a>
            <button type="submit" class="admin-btn admin-btn--primary">Save Changes</button>
        </div>
    </form>

    <div class="admin-panel" style="margin-top: 20px;">
        <div class="admin-panel__header">
            <div>
                <h3 class="admin-panel__title">Product Status</h3>
                <p class="admin-panel__subtitle">Control visibility on the storefront</p>
            </div>
        </div>

        <div class="admin-status-actions">
            <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="admin-btn admin-btn--outline">
                    {{ $product->is_active ? 'Deactivate Product' : 'Activate Product' }}
                </button>
            </form>

            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                onsubmit="return confirm('Delete {{ $product->name }}? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn--danger">Delete Product</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            var nameInput = document.getElementById('name');
            var slugInput = document.getElementById('slug');
            var skuInput = document.getElementById('sku');
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

            document.getElementById('generateSkuBtn').addEventListener('click', function () {
                var base = slugify(nameInput.value || 'product').toUpperCase().slice(0, 20);
                var random = Math.floor(1000 + Math.random() * 9000);
                skuInput.value = (base || 'PRODUCT') + '-' + random;
            });
        })();

        (function () {
            var input = document.getElementById('productImageInput');
            var preview = document.getElementById('productImagePreview');
            var removeCheckbox = document.getElementById('productImageRemove');
            var placeholderTemplate = document.getElementById('productImagePlaceholderTemplate');

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

        (function () {
            var grid = document.getElementById('galleryGrid');
            var removeInputsContainer = document.getElementById('removeGalleryInputs');

            grid.querySelectorAll('.js-remove-existing-image').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var item = btn.closest('.admin-gallery-item');
                    var hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'remove_gallery_images[]';
                    hidden.value = btn.dataset.id;
                    removeInputsContainer.appendChild(hidden);
                    item.remove();
                });
            });
        })();

        (function () {
            var input = document.getElementById('galleryInput');
            var grid = document.getElementById('galleryGrid');
            var addTile = document.getElementById('galleryAddTile');
            var dataTransfer = new DataTransfer();

            function render() {
                grid.querySelectorAll('.admin-gallery-item:not([data-existing-id])').forEach(function (el) {
                    el.remove();
                });

                Array.prototype.slice.call(dataTransfer.files).forEach(function (file, index) {
                    var item = document.createElement('div');
                    item.className = 'admin-gallery-item';

                    var img = document.createElement('img');
                    item.appendChild(img);

                    var removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'admin-gallery-item__remove';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.setAttribute('aria-label', 'Remove image');
                    removeBtn.addEventListener('click', function () {
                        var next = new DataTransfer();
                        Array.prototype.slice.call(dataTransfer.files).forEach(function (f, i) {
                            if (i !== index) {
                                next.items.add(f);
                            }
                        });
                        dataTransfer = next;
                        input.files = dataTransfer.files;
                        render();
                    });
                    item.appendChild(removeBtn);

                    grid.insertBefore(item, addTile);

                    var reader = new FileReader();
                    reader.onload = function (event) {
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }

            input.addEventListener('change', function () {
                Array.prototype.slice.call(input.files).forEach(function (file) {
                    dataTransfer.items.add(file);
                });
                input.files = dataTransfer.files;
                render();
            });
        })();

        (function () {
            var categorySelect = document.getElementById('category_id');
            var tagSelect = document.getElementById('tag_id');
            var tagOptions = Array.prototype.slice.call(tagSelect.options);

            function filterTags() {
                var categoryId = categorySelect.value;

                tagOptions.forEach(function (option) {
                    if (!option.value) {
                        return;
                    }

                    var matches = option.dataset.category === categoryId;
                    option.hidden = !matches;
                    option.disabled = !matches;
                });

                var selected = tagSelect.options[tagSelect.selectedIndex];
                if (selected && selected.disabled) {
                    tagSelect.value = '';
                }
            }

            categorySelect.addEventListener('change', filterTags);
            filterTags();
        })();
    </script>
@endpush
