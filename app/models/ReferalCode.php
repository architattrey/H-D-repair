<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ReferalCode extends Model
{
    protected $table = 'referal_codes';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'referal_code',
        'redmeed_id',
        'delete_status',
        'created_at',
        'updated_at'
    ]; 
}
