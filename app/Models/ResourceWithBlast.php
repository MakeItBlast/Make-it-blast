<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceWithBlast extends Model
{
    use HasFactory;

    protected  $fillable = [
        'resource_id',
        'blast_id',
        'user_id',
    ];
}
