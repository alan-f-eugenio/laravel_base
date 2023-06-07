<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Define extends Model {
    use HasFactory;

    protected $fillable = [
        'update_user_id',
        'page_title',
        'page_meta_keywords',
        'page_meta_description',
        'company_fancy_name',
        'company_corporate_name',
        'company_cep',
        'company_opening_hours',
        'company_cnpj',
        'company_address',
        'company_email',
        'company_phone',
        'company_whats',
        'company_face',
        'company_insta',
        'company_yout',
    ];
}
