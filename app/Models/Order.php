<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['name', 'address1','phone1','address2','phone2', 'email'];

    public function food()
    {
        return $this->hasMany(Food::class);
    }
}
