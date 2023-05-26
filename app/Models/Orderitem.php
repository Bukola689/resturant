<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['order_id', 'food_id', 'price', 'quantity'];

    public function food()
    {
        return $this->hasMany(Food::class);
    }
}
