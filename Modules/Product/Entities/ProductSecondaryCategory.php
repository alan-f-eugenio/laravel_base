<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSecondaryCategory extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'product_category_id',
    ];

    public function products() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
