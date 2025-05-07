<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'yearly_discount',
        'cost_per_blast',
        'dollar_value',
    ];
}
