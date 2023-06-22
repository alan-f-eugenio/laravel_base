<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFile extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'ordem',
        'filename',
        'type',
    ];
}
