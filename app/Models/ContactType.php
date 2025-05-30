<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    use HasFactory;
    protected $fillable = [
        'contact_type',
        'user_id',
        'contact_desc',
        'status',
    ];
}
