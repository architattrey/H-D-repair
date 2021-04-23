<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat_id',
        'sub_categories',
        'images',
        'delete_status',
        'created_at',
        'updated_at'
    ];
    public function serviceFeatures()
    {
        return $this->hasMany('App\models\ServiceFeature','subcat_id', 'id');
    }
}
