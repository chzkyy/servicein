<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchant';

    protected $fillable = [
        'user_id',
        'merchant_name',
        'merchant_desc',
        'merchant_address',
        'open_hour',
        'close_hour',
        'phone_number',
        'geo_location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function merchant_gallery()
    {
        return $this->hasMany(MerchantGallery::class, 'merchant_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'merchant_id', 'id');
    }

}
