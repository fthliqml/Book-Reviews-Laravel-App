<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Define that book can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
