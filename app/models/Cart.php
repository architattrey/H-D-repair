<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'service_type_id',
        'user_id',
        'created_at',
        'updated_at',
    ];
}
