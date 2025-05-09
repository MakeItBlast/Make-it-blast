<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlastInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blast_invoice_num',
        'blast_id',
    ];

    /**
     * Get the user associated with the invoice.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the blast associated with the invoice.
     */
    public function blast()
    {
        return $this->belongsTo(Blast::class);
    }
}
