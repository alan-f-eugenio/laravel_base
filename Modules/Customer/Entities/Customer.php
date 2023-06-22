<?php

namespace Modules\Customer\Entities;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Customer\Helpers\CustomerAddressTypes;
use Modules\Customer\Helpers\CustomerPersons;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory, SoftDeletes;

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

    protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\CustomerFactory::new();
    }
}
