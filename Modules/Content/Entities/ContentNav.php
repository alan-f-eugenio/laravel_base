<?php

namespace Modules\Content\Entities;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Content\Database\factories\ContentNavFactory;
use Modules\Content\Helpers\ContentNavTypes;

class ContentNav extends Model {
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

    protected static function newFactory() {
        return ContentNavFactory::new();
    }

    public function contents() {
        return $this->hasMany(Content::class);
    }
}
