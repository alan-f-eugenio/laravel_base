<?php

namespace Modules\Banner\Entities;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Banner\Database\factories\BannerFactory;

class Banner extends Model {
    use HasFactory, SoftDeletes;

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

    protected static function newFactory() {
        return BannerFactory::new();
    }

    public function local() {
        return $this->belongsTo(BannerLocal::class, 'local_id');
    }
}
