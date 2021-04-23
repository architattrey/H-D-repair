<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UsersFeedbacks extends Model
{
    protected $table = 'users_feedbacks';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'feedbacks',
        'created_at',
        'updated_at',
    ];
     
}
