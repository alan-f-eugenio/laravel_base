<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRelated extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'product_id2',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function product2() {
        return $this->hasOne(Product::class, 'product_id2');
    }
}
