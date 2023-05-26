<?php

namespace App\Models;

use App\Events\Cache\FoodCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => FoodCreated::class,
    ];

    protected $fillable = ['name', 'price', 'quantity' ,'image', 'description'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}
