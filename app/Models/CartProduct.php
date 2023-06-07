<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

        return $this->hasOne(Product::class, 'id', 'product_id')
            ->with('parent', function ($query) {
                $query->whereNotNull('id');
            })
            ->with('attribute1', function ($query) {
                $query->whereNotNull('id');
            })
            ->with('option1', function ($query) {
                $query->whereNotNull('id');
            })
            ->with('attribute2', function ($query) {
                $query->whereNotNull('id');
            })
            ->with('option2', function ($query) {
                $query->whereNotNull('id');
            });
    }
}
