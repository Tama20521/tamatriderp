<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'total',
        'payment_type',
        'due_date',
        'paid_amount',
    ];

    protected $casts = [
        'total'       => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date'    => 'date',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'subtotal')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ============ HELPERS ============
    
    /** Saldo pendiente por cobrar */
    public function getBalanceAttribute()
    {
        return max(0, $this->total - $this->paid_amount);
    }

    /** Estado del pago */
    public function getPaymentStatusAttribute()
    {
        if ($this->paid_amount >= $this->total) return 'paid';
        if ($this->paid_amount > 0) return 'partial';
        return 'pending';
    }

    /** ¿Está vencida? */
    public function getIsOverdueAttribute()
    {
        return $this->due_date 
            && $this->due_date->isPast() 
            && $this->payment_status !== 'paid';
    }
}