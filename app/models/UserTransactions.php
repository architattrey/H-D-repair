<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserTransactions extends Model
{
    protected $table = 'user_transactions';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'user_id',
        'service_provider_id',
        'service_type_id',
        'invoice_id',
        'phone_number',
        'amount',
        'dlvry_address',
        'lat',
        'lng',
        'dlvry_status',
        'created_at',
        'updated_at',
    ];
    #service provider
    public function serviceProvider(){

        return $this->belongsTo('App\models\ServiceProvider', 'service_provider_id', 'id');
    }
     
    
}
