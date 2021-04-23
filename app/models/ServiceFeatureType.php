<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceFeatureType extends Model
{
    protected $table = 'service_feature_types';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'service_features_id',
        'type',
        'image',
        'delete_status',
        'created_at',
        'updated_at'
    ];
    #get cart 
    public function getCart()
    {
        return $this->hasMany('App\models\Cart','service_type_id','id');
    }
}
