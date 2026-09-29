<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'document',
        'address',
        'website',
        'notes',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Total de productos del proveedor
    public function getTotalProductosAttribute()
    {
        return $this->products()->count();
    }

    // Valor del inventario del proveedor
    public function getValorInventarioAttribute()
    {
        return $this->products()->selectRaw('SUM(price * stock) as total')->value('total') ?? 0;
    }
}