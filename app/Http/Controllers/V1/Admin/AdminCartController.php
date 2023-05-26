<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdminCartController extends Controller
{
    public function allCart(Request $request)
    {
        $carts = Cache::remember('carts', 60, function() {
            return Cart::orderBy('id', 'asc')->get();
        });
        
        return response()->json($carts);

        
    }
}
