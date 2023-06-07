<?php

namespace App\Models;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {
    use HasFactory, SoftDeletes;

    // const STATUS_ATIVO = 1;
    // const STATUS_INATIVO = 2;
    protected $with = [
        'local',
    ];

    protected $fillable = [
        'create_user_id',
        'update_user_id',
        'local_id',
        'status',
        'ordem',
        'title',
        'link',
        'filename',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
    ];

    public function local() {
        return $this->belongsTo(BannerLocal::class, 'local_id');
    }

}
