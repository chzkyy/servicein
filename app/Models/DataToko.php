<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataToko extends Model
{
    use HasFactory;

    protected $table = 'data_toko';

    protected $fillable = [
        'user_id',
        'toko_name',
        'toko_desc',
        'toko_address',
        'open_hour',
        'close_hour',
        'gallery',
        'geo_location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


}
