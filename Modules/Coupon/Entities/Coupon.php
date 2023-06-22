<?php

namespace Modules\Coupon\Entities;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Coupon\Database\factories\CouponFactory;
use Modules\Coupon\Helpers\CouponDiscountTypes;

class Coupon extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'create_user_id',
        'update_user_id',
        'status',
        'token',
        'description',
        'qtd',
        'date_start',
        'date_end',
        'value_min',
        'value_max',
        'discount',
        'discount_type',
        'first_buy',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
        'discount_type' => CouponDiscountTypes::class,
    ];

    protected static function newFactory() {
        return CouponFactory::new();
    }

    protected function discount(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => (isset($attributes['discount_type']) && $attributes['discount_type'] == CouponDiscountTypes::TYPE_AMOUNT->value
                ? str_replace('.', ',', $value)
                : (int) $value)
        );
    }

    protected function valueMin(): Attribute {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }

    protected function valueMax(): Attribute {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }
}
