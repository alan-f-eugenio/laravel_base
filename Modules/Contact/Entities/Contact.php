<?php

namespace Modules\Contact\Entities;

use App\Helpers\ContactStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'update_user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'seen',
        'cro',
        'qtd',
    ];

    protected $casts = [
        'seen' => ContactStatus::class,
    ];


    protected static function newFactory() {
        return \Modules\Contact\Database\factories\ContactFactory::new();
    }
}
