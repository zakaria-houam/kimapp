<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'model', 'year', 'color', 'energie', 'marque_id', 'motor', 'wilaya', 'price_per_day', 'pictures'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
}
