<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Contact\Database\factories\ContactFactory;
use Modules\Contact\Helpers\ContactStatus;

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
        return ContactFactory::new();
    }
}
