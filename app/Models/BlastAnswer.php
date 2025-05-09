<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlastAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'contact_id',
        'question_id',
        'medium',
    ];

    // Relationship to Contact
    public function contact()
    {
        return $this->belongsTo(ContactImportData::class);
    }

    // Relationship to Question
    public function question()
    {
        return $this->belongsTo(BlastQuestion::class);
    }
}
