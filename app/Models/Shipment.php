<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    const STATUS_UNASSIGNED = "unassigned";
    const STATUS_COMPLETED = 'completed';
    const STATUS_PROBLEM = 'problem';
    const STATUS_IN_PROGRESS = 'in_progress';

    const ALLOWED_STATUSES = [
        self::STATUS_UNASSIGNED,
        self::STATUS_COMPLETED,
        self::STATUS_PROBLEM,
        self::STATUS_IN_PROGRESS,
    ];

    protected $fillable = [
        'title', 'from_city', 'from_country',
        'to_city', 'to_country', 'price',
        'status', 'user_id', 'details',
    ];

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

}
