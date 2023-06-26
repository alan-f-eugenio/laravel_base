<?php

namespace Modules\Product\Entities;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Database\factories\ProductFactory;
use Modules\Product\Helpers\ProductHasChildTypes;
use Modules\Product\Helpers\ProductTypes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model {
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'id',
        'id_parent',
        'create_user_id',
        'update_user_id',
        'product_category_id',
        'has_child',
        'product_att1_id',
        'product_att2_id',
        'product_opt1_id',
        'product_opt2_id',
        'created_at',
        'updated_at',
        'status',
        'type',
        'ordem',
        'sku',
        'name',
        'slug',
        'ean',
        'stock',
        'weight',
        'width',
        'height',
        'depth',
        'price',
        'price_cost',
        'promo_value',
        'promo_date_in',
        'promo_date_end',
        'deadline',
        'warranty',
        'brand',
        'page_title',
        'meta_keywords',
        'meta_description',
        'text',
        'filename',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
        'type' => ProductTypes::class,
        'has_child' => ProductHasChildTypes::class,
    ];

    protected static function newFactory() {
        return ProductFactory::new();
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function secondaryCategories() {
        return $this->belongsToMany(ProductCategory::class, 'product_secondary_categories', 'product_id', 'product_category_id');
    }

    public function getAllCategories() {
        if ($this->category->count() && $this->secondaryCategories->count()) {
            return $this->category->push(...$this->secondaryCategories);
        } elseif ($this->category->count()) {
            return [$this->category];
        } elseif ($this->secondaryCategories->count()) {
            return [$this->secondaryCategories];
        } else {
            return [];
        }
    }

    public function childs() {
        return $this->hasMany(Product::class, 'id_parent', 'id')->orderBy('ordem', 'asc')
            ->with('attribute1', 'option1','attribute2', 'option2')
            ->withoutTrashed();
    }

    public function parent() {
        return $this->belongsTo(Product::class, 'id_parent');
    }

    public function attribute1() {
        return $this->hasOne(ProductAttribute::class, 'id', 'product_att1_id');
    }

    public function attribute2() {
        return $this->hasOne(ProductAttribute::class, 'id', 'product_att2_id');
    }

    public function option1() {
        return $this->hasOne(ProductAttributeOpt::class, 'id', 'product_opt1_id');
    }

    public function option2() {
        return $this->hasOne(ProductAttributeOpt::class, 'id', 'product_opt2_id');
    }

    public function images() {
        return $this->hasMany(ProductFile::class, 'product_id', 'id')->where('type', 'like', '%image%')->orderBy('ordem', 'asc')->withoutTrashed();
    }

    public function relatedProducts() {
        return $this->hasManyThrough(Product::class, ProductRelated::class, 'product_id', 'id', 'id', 'product_id2');
    }

    protected function priceCost(): Attribute {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }

    protected function price(): Attribute {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }

    protected function promoValue(): Attribute {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }

    protected function weight(): Attribute {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }
}
