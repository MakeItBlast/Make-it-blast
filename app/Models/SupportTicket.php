<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'ticket_id',
        'message',
        'priority',
        'supporting_image',
        'user_id',
        'status',
        'problem_type',
    ];

    public function issueType()
{
    return $this->belongsTo(IssueType::class, 'problem_type');
}
}
