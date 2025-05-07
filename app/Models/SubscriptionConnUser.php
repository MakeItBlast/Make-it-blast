<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionConnUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'subscription_id',
        'user_id',
        'amt_type',
    ];
}

