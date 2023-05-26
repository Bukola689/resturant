<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['food_id', 'quantity','price', 'user_id'];

    public function food()
    {
        return $this->hasMany(Food::class, 'id', 'food_id');
    }
}
