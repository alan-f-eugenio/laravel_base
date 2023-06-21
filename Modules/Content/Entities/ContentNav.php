<?php

namespace Modules\Content\Entities;

use App\Helpers\ContentNavTypes;
use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentNav extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = [
        'contents',
    ];

    protected $fillable = [
        'create_user_id',
        'update_user_id',
        'content_nav_id',
        'status',
        'slug',
        'title',
        'type',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
        'type' => ContentNavTypes::class,
    ];

    public function contents() {
        return $this->hasMany(Content::class);
    }

    protected static function newFactory()
    {
        return \Modules\Content\Database\factories\ContentNavFactory::new();
    }
}
