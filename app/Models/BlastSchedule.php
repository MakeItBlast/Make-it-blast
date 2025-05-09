<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlastSchedule extends Model
{
    use HasFactory;

     protected $fillable = [
        'blast_id',
        'user_id',
        'date',
        'time',
        'time_zone',
    ];
    
    public function blast()
    {
        return $this->belongsTo(Blast::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

