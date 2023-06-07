<?php

namespace App\Models;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model {
    use HasFactory;

    protected $fillable = [
        'id',
        'update_user_id',
        'status',
        'defines',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
    ];
}
