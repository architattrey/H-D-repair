<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'state',
        'created_at',
        'updated_at',
    ];
}
