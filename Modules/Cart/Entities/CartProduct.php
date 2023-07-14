<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Product;

class CartProduct extends Model {
    use HasFactory, SoftDeletes;

    protected $with = [
        'product',
    ];

    protected $fillable = [
        'cart_id',
        'product_id',
        'qtd',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product() {

        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
