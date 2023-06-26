<?php

namespace Modules\Product\Entities;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Database\factories\ProductCategoryFactory;

class ProductCategory extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = [
        'create_user_id',
        'update_user_id',
        'id_parent',
        'status',
        'name',
        'text',
        'page_title',
        'meta_keywords',
        'meta_description',
        'filename',
        'ordem',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
    ];

    protected static function newFactory() {
        return ProductCategoryFactory::new();
    }

    public function parent() {
        return $this->belongsTo(ProductCategory::class, 'id', 'id_parent');
    }

    public function allParents() {
        return $this->hasMany(ProductCategory::class, 'id', 'id_parent')->with('allParents');
    }

    public function children() {
        return $this->hasMany(ProductCategory::class, 'id_parent')->orderBy('ordem', 'asc');
    }

    public function allChilds() {
        return $this->hasMany(ProductCategory::class, 'id_parent')->with('allChilds')->orderBy('ordem', 'asc');
    }

    public function products() {
        return $this->hasMany(Product::class, 'product_category_id', 'id')->where('status', DefaultStatus::STATUS_ATIVO->value)->whereNull('id_parent')->with('category');
    }

    public function secondaryProducts() {
        return $this->hasManyThrough(Product::class, ProductSecondaryCategory::class, 'product_category_id', 'id', 'id', 'product_id')->whereNull('id_parent')->where('status', DefaultStatus::STATUS_ATIVO->value);
    }

    public function getAllProducts() {
        if ($this->products->count() && $this->secondaryProducts->count()) {
            return $this->products->push(...$this->secondaryProducts);
        } elseif ($this->products->count()) {
            return $this->products;
        } elseif ($this->secondaryProducts->count()) {
            return $this->secondaryProducts;
        } else {
            return new Collection;
        }
    }
}
