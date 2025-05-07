<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_method',
        'transaction_id',
        'amount',
        'status',
        'currency',
        'response_data',
        'gateway_reference',
        'payment_date',
        'description',
        'refund_status'
    ];
}
