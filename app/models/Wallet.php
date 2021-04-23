<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'redmeed_id',
        'amount',
        'method',
        'transaction_type',
        'created_at',
        'updated_at'
    ]; 
}
