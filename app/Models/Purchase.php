<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'invoice_number',
        'total',
        'payment_type',
        'due_date',
        'paid_amount',
        'notes',
    ];

    protected $casts = [
        'total'       => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date'    => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'purchase_product')
            ->withPivot('quantity', 'unit_cost', 'subtotal')
            ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    // Helpers
    public function getBalanceAttribute()
    {
        return max(0, $this->total - $this->paid_amount);
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->paid_amount >= $this->total) return 'paid';
        if ($this->paid_amount > 0) return 'partial';
        return 'pending';
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->payment_status !== 'paid';
    }
}
