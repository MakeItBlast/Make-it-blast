<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlastLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blast_id',
        'contact_id',
        'status',
    ];
}
