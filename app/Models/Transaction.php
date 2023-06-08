<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table ='transaction';

    protected $fillable = [
        'booking_id',
        'user_id',
        'merchant_id',
        'no_transaction',
        'status',
        'user_note',
        'merchant_note',
        'service_confirmation',
        'waranty',
        'picture',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'transaction_id');
    }

    public function transaction_detail()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

}