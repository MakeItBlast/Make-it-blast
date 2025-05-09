<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'subsc_name',
        'keyword_allowed_count',
        'duration',
        'credit_cost',
        'monthly_cost',
        'discount',
        'yearly_cost',
        'surcharge',
        'sms_allowed_count',
        'email_allowed_count',
        'social_allowed_count',
        'ai_allowed_count',
        'image_allowed_count',
        'replies_allowed_count',
        'status',
    ];
}
 