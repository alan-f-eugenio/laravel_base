<?php

namespace Modules\Product\Entities;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Database\factories\ProductAttributeFactory;

class ProductAttribute extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'create_user_id',
        'update_user_id',
        'status',
        'name',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
    ];

    protected static function newFactory() {
        return ProductAttributeFactory::new();
    }

    public function options() {
        return $this->hasMany(ProductAttributeOpt::class)->orderBy('ordem', 'asc');
    }
}
