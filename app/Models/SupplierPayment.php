<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'user_id',
        'amount',
        'payment_method',
        'reference',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'amount'  => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
