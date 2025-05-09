<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Model
{
    use HasFactory;
    protected $fillable = [
        'rsrc_type',
        'rsrc_name',
        'rsrc_value',
        'user_id',
        'status',
    ];
}

