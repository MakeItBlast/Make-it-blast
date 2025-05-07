<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMediaLogin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'status',

    ];
}
 