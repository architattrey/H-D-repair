<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderDocuments extends Model
{
    protected $table = 'service_provider_documents';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
       
        'service_provider_id',
        'name_on_id',
        'document_number',
        'document_type',
        'documents',
        'delete_status',
        'created_at',
        'updated_at'
    ];
    // public function documents()
    // {
    //     return $this->belongsTo('App\models\ServiceProviderDocuments','service_provider_id');
    // }
}
