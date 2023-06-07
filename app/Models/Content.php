<?php

namespace App\Models;

use App\Helpers\DefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model {
    use HasFactory, SoftDeletes;

    // protected $with = [
    //     'nav'
    // ];

    protected $fillable = [
        'create_user_id',
        'update_user_id',
        'content_nav_id',
        'status',
        'slug',
        'title',
        'subtitle',
        'author',
        'link',
        'page_title',
        'meta_keywords',
        'meta_description',
        'text',
        'abstract',
        'filename',
    ];

    protected $casts = [
        'status' => DefaultStatus::class,
    ];

    public function nav() {
        return $this->belongsTo(ContentNav::class, 'content_nav_id');
    }
}
