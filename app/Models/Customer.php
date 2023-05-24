<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $fillable = [
        'user_id',
        'fullname',
        'dob',
        'phone_number',
        'gender',
        'cust_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
