<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceFeature extends Model
{
    protected $table = 'service_features';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat_id',
        'subcat_id',
        'service_type',
        'delete_status',
        'created_at',
        'updated_at'
    ];
    public function subCategories()
    {
        return $this->belongsTo('App\models\SubCategory', 'subcat_id', 'id');
    }
}
