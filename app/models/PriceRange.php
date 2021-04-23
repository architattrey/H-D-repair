<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    protected $table = 'price_ranges';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'range',
        'delete_status',
        'created_at',
        'updated_at',
    ];
}
