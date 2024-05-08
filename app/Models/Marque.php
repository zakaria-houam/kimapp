<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
