<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BannerLocal extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected static function newFactory()
    {
        return \Modules\Banner\Database\factories\BannerLocalFactory::new();
    }
}
