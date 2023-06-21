<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'update_user_id',
        'name',
        'email',
    ];

    protected static function newFactory()
    {
        return \Modules\Email\Database\factories\EmailFactory::new();
    }
}
