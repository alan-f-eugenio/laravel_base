<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Banner\Database\factories\BannerLocalFactory;

class BannerLocal extends Model {
    use HasFactory;

    public $timestamps = false;

    protected static function newFactory() {
        return BannerLocalFactory::new();
    }
}
