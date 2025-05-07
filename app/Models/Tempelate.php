<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempelate extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tempelate_structure',
        'tempelate_by',
        'temp_name',
        'status',
    ];
}

