<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Coupon\Entities\Coupon;
use Modules\Customer\Entities\Customer;

class Cart extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'coupon',
        'session_id',
        'shipping_cep',
        'shipping_value',
        'updated_at',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function coupon() {
        return $this->hasOne(Coupon::class, 'token', 'coupon');
    }

    public function cartProducts() {
        return $this->hasMany(CartProduct::class, 'cart_id', 'id');
    }

    public function allCartProducts() {
        return $this->hasMany(CartProduct::class, 'cart_id', 'id')->withTrashed();
    }

    protected function shippingCep(): Attribute {
        return Attribute::make(
            get: fn ($value) => strpos($value, '-') !== false || !$value ? $value : substr($value, 0, 5) . '-' . substr($value, 5),
        );
    }

    protected function shippingValue(): Attribute {
        return Attribute::make(
            get: fn ($value) => str_replace('.', ',', $value),
        );
    }
}
