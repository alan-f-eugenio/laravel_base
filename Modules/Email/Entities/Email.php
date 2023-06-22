<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Email\Database\factories\EmailFactory;

class Email extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'update_user_id',
        'name',
        'email',
    ];

    protected static function newFactory() {
        return EmailFactory::new();
    }
}
