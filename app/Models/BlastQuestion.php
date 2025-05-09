<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlastQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
      'question',
        'blast_id',
        'status',
        'question_placing',
    ];


    public function blast()
    {
        return $this->belongsTo(Blast::class, 'blast_id');
    }
}
