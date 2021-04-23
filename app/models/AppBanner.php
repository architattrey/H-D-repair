<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class AppBanner extends Model
{
    protected $table = 'app_banners';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'image',
        'delete_status',
        'created_at',
        'updated_at',
    ];
}
