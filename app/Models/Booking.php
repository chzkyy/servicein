<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table ='booking';

    protected $fillable = [
        'customer_id',
        'merchant_id',
        'device_id',
        'booking_code',
        'booking_date',
        'booking_time',
        'picture',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'booking_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    

}