<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model {
    use HasFactory, SoftDeletes;

    const STATUS_NOVO = 0;

    const STATUS_VISTO = 1;

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
}
