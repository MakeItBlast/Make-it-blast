<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlastAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'answer',
        'blast_id',
        'contact_id',
    ];
}
