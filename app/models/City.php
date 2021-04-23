<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'state_id',
        'city',
        'created_at',
        'updated_at',
    ];
}
