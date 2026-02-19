<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentDocuments extends Model
{
    protected $fillable = [
        'shipment_id', 'document_name'
    ];
}
