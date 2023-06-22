<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Customer\Helpers\CustomerAddressTypes;

class CustomerAddress extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'type',
        'recipient',
        'cep',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    protected $casts = [
        'type' => CustomerAddressTypes::class,
    ];

    public function customer() {
        $this->belongsTo(Customer::class, 'customer_id');
    }

    protected static function newFactory() {
        return \Modules\Customer\Database\factories\CustomerAddressFactory::new();
    }
}
