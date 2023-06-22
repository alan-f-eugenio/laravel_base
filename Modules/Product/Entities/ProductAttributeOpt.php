<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Database\factories\ProductAttributeOptFactory;

class ProductAttributeOpt extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_attribute_id',
        'create_user_id',
        'update_user_id',
        'name',
        'ordem',
        'filename',
        'created_at',
        'updated_at',
        'id',
    ];

    protected static function newFactory() {
        return ProductAttributeOptFactory::new();
    }

    public function attribute() {
        return $this->belongsTo(ProductAttribute::class);
    }
}
