<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTypeWithBlast extends Model
{
    use HasFactory;
    protected $fillable = [
        'contact_type_id',
        'user_id',
        'blast_id',
    ];
}
