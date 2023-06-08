<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'device';

    protected $fillable = [
        'user_id',
        'device_name',
        'type',
        'brand',
        'serial_number',
        'device_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function booking()
    {
        return $this->hasMany(Booking::class, 'device_id');
    }
}