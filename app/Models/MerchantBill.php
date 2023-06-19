<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantBill extends Model
{
    use HasFactory;

    protected $table = 'merchant_bill';

    protected $fillable = [
        'merchant_id',
        'no_bill',
        'amount',
        'proof_of_payment',
        'bills_date',
        'status',
        'reason',
        'approved_by',
        'rejected_by',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }
}
