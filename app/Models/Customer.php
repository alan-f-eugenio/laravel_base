<?php

namespace App\Models;

use App\Helpers\CustomerAddressTypes;
use App\Helpers\CustomerPersons;
use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable {
    use Notifiable, HasFactory, SoftDeletes;

    protected $fillable = [
        'create_user_id',
        'update_user_id',
        'status',
        'person',
        'fullname',
        'cpf',
        'rg',
        'cnpj',
        'date_birth',
        'state_registration',
        'corporate_name',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
        'person' => CustomerPersons::class,
    ];

    public function addresses() {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function mainAddress() {
        return $this->hasOne(CustomerAddress::class, 'customer_id')->where('type', CustomerAddressTypes::TYPE_PRINCIPAL->value);
    }

    public function secondaryAddress() {
        return $this->hasOne(CustomerAddress::class, 'customer_id')->where('type', CustomerAddressTypes::TYPE_ENTREGA->value);
    }
}
