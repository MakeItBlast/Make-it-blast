<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMetaData extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'address',
        'zipcode',
        'city',
        'state',
        'country',
        'billing_email',      
        'avatar',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

