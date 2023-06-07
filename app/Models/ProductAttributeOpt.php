<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function attribute() {
        return $this->belongsTo(ProductAttribute::class);
    }
}
