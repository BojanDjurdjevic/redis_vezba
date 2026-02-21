<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Shipment extends Model
{
    use HasFactory;

    const STATUS_UNASSIGNED = "unassigned";
    const STATUS_COMPLETED = 'completed';
    const STATUS_PROBLEM = 'problem';
    const STATUS_IN_PROGRESS = 'started';

    const ALLOWED_STATUSES = [
        self::STATUS_UNASSIGNED,
        self::STATUS_COMPLETED,
        self::STATUS_PROBLEM,
        self::STATUS_IN_PROGRESS,
    ];

    protected $table = 'shipments';

    protected $fillable = [
        'title', 'from_city', 'from_country',
        'to_city', 'to_country', 'price',
        'status', 'user_id', 'details', 'client_id',
    ];

    public static function booted()
    {
        static::created(function($shipment) {
            if($shipment->status === self::STATUS_UNASSIGNED) {
                Cache::forget('unassigned_shipments');
            }
        }); 

        static::saved(fn($shipment)=> Cache::forget('unassigned_shipments')); 

        static::deleted(fn($shipment)=> Cache::forget('unassigned_shipments')); 
    }

    public function setStatusAttribute($status)
    {
        if(!in_array($status, self::ALLOWED_STATUSES)) {
            throw new \Exception('Invalid status');
        }

        $this->attributes['status'] = $status;
    }

    public function documents()
    {
        return $this->hasMany(ShipmentDocuments::class);
    }

    public function trucker()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function scopeUnassignedShipments($query)
    {
        return $query->where('status', self::STATUS_UNASSIGNED);
    }

}
