<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactImportData extends Model
{
    use HasFactory;


    protected $fillable = [
        'c_fname',
        'c_lname',
        'c_email',
        'c_phno',
        'c_country',
        'c_city',
        'c_state',
        'c_timezone',
        'user_id',
        'contact_type_id',
        'status',
    ];

    // Relationship with ContactType
    public function contactType()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


