<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionConnUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'payment_id',
        'amt_type',
        'status'
    ];

    // Define the relationship with Subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    // Define the relationship with Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}