<?php

namespace App\Http\Controllers\V1\Customer\Auth;

use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $food_id = $request->input('food_id');

        if(Auth::check()) 
        {
         $food = Food::where('id', $food_id)->first();

         if($food)
         {
            if(Cart::where('food_id', $food_id)->where('user_id', Auth::id())->exists())
            {
                return response()->json([
                    'message' => $food->name, 'Exist on Cart'
                ]);
            }

            else {
                $cart = new Cart();
                $cart->food_id = $food_id;
                $cart->quantity = $food->quantity;
                $cart->price = $food->price;
                $cart->user_id = auth()->user()->id;
                $cart->save();

                return response()->json([
                    'message' => 'Cart Added Succesfully !',
                    'status' => $cart
                ]);
            }
         }
        } else {
            return response()->json([
                'message' => 'Login To Continue'
            ]);
        }
        
    }

    public function viewCart()
    {
    
     if(Auth::id())
     {
        $user_id = Auth::id();

        $count = Cart::where('user_id', $user_id)->count();

        $myCart = Cart::orderBy('id', 'desc')->get();

        return response()->json([$count, $myCart]);
     }

    }

    public function increment(Request $request)
    {
        if(Auth::id())
        {
            $food_id = $request->input('food_id');

            if(Cart::where('food_id', $food_id)->where('user_id', Auth::id())->exists())
            {
                $cart = Cart::where('food_id', $food_id)->where('user_id', Auth::id())->first();
                $cart->increment('quantity', 1);

               

                return response()->json([
                    'message' => 'Cart Increased Successfully !',
                    'cart' => $cart
                ]);
            }

        }
    }

    public function decrement(Request $request)
    {
        if(Auth::id())
        {
            $food_id = $request->input('food_id');

            if(Cart::where('food_id', $food_id)->where('user_id', Auth::id())->exists())
            {
                $cart = Cart::where('food_id', $food_id)->where('user_id', Auth::id())->first();
                
                $cart->decrement('quantity', 1);
            }

            return response()->json([
                'message' => 'Cart decreased Successfully !',
                'status' => $cart
            ]);
        }
    }

    public function removeCart(Request $request)
    {
        if(Auth::id())
        {
            $food_id = $request->input('food_id');

            if(Cart::where('food_id', $food_id)->where('user_id', Auth::id())->exists())
            {
                $cart = Cart::where('food_id', $food_id)->where('user_id', Auth::id())->first();
                
                $cart->delete();
            }

            return response()->json([
                'message' => 'Cart removed Successfully !',
                'status' => $cart
            ]);
        }
    }
}
