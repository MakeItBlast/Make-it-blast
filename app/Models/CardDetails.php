<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'f_name',
        'l_name',
        'card_number',
        'cvv',
        'exp_date',
        'country',
        'state',
        'city',
        'priority',
        'status',
        'user_id'
    ];
}
