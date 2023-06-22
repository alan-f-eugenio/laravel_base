<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model {
    use HasFactory, LogsActivity;

    protected $fillable = [
        'customer_id',
        'cart_id',
        'coupon_id',
        'update_user_id',
        'status',
        'recipient',
        'cep',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'shipping_service',
        'shipping_code',
        'shipping_value',
        'payment_service',
        'coupon',
        'discount',
        'value',
        'installments',
        'tid',
        'payment_link',
        'payment_code',
        'payment_expiration',
        'customer_obs',
        'obs',
    ];

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
