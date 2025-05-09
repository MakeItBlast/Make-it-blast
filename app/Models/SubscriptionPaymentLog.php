<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'subscription_items',
        'stripe_response',
    ];
}
