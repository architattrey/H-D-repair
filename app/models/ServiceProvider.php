<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $table = 'service_providers';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat',
        'sub_cat',
        'name',
        'phone',
        'image',
        'address',
        'district',
        'state',
        'pin_code',
        'price',
        'price_range_id',
        'status',
        'delete_status',
        'created_at',
        'updated_at'
    ];
    public function documents()
    {
        return $this->hasMany('App\models\ServiceProviderDocuments','service_provider_id','id');
    }
    public function priceRange(){

        return $this->belongsTo('App\models\PriceRange','price_range_id');
    }
}
