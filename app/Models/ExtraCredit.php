<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraCredit extends Model
{
    use HasFactory;
    protected $fillable = [
        'trx_id',
        'credit',
    ];
}
