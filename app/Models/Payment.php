<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'transaction_id',
        'amount',
        'status',
        'currency',
        'response_data',
        'gateway_reference',
        'payment_date',
        'description',
        'refund_status',
        'coupon_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'trx_id', 'id');
    }
    
}
