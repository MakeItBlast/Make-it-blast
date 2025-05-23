<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];
}
