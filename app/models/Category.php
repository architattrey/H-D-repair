<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'categories',
        'alternate_name',
        'images',
        'delete_status',
    ];
    // public function serviceFeatures()
    // {
    //     return $this->hasMany('App\models\ServiceFeature','cat_id', 'id');
    // }
}
