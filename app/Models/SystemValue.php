<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'system_key',
        'system_val',
    ];
}
