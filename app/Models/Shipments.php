<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'from_city', 'from_country',
        'to_city', 'to_country', 'price',
        'status', 'user_id', 'details',
    ];



}
