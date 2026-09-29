<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'document',
        'address',
        'notes',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Total comprado por este cliente
    public function getTotalCompradoAttribute()
    {
        return $this->sales()->sum('total') ?? 0;
    }

    // Cantidad de compras
    public function getCantidadComprasAttribute()
    {
        return $this->sales()->count();
    }
}