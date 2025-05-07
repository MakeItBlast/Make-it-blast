<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blast extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blast_name',
        'tempelate_id',
        'tempelate_structure',
        'status',
    ];
 
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->tempelate_id) === empty($model->tempelate_structure)) {
                throw new \Exception('Either tempelate_id or tempelate_structure must be provided, but not both.');
            }
        });
    }
}
