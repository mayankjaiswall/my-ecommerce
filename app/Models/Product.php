<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'tag_id',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'compare_price',
        'stock_quantity',
        'low_stock_threshold',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? Storage::disk('public')->url($this->image) : null,
        );
    }

    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->stock_quantity <= 0) {
                    return 'out_of_stock';
                }

                if ($this->stock_quantity <= $this->low_stock_threshold) {
                    return 'low_stock';
                }

                return 'in_stock';
            },
        );
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $suffix = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
