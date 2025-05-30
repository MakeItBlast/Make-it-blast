<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempelate extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'template_structure',
        'template_by',
        'temp_name',
        'status',
    ];
}

