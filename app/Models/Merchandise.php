<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'brand', 
        'product', 
        'description', 
        'price', 
        'quantity',
        'user_id',
    ];

    public function container() {
        return $this->belongsTo('App\Models\Merchandise', 'price', 'id');
    }
}
