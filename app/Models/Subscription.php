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
        'status',
    ];
}
 