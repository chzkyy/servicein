<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantGallery extends Model
{
    use HasFactory;
    protected $table = 'merchant_gallery';

    protected $fillable = [
        'merchant_id',
        'images',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'id', 'merchant_id');
    }

}
