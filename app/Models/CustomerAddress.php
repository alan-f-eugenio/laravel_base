<?php

namespace App\Models;

use App\Helpers\CustomerAddressTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
