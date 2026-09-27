<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['user_id','total'];
    protected $casts = ['total'=>'decimal:2',
    
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withPivot ('quantity','subtotal')
        ->withTimestamps();
    }
    public function user()
    {
       return $this->belongsTo(User::class); 
    }   
     
}
