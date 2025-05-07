<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionConnService extends Model
{
    use HasFactory;
    protected $fillable = [
        'subscription_id',
        'service_id',
    ];
}
