<?php

namespace App\Http\Controllers\V1\Customer\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartitemController extends Controller
{
   public function cartItem(Request $request)
   {
      $cartitems = Cart::with('food')->where('user_id', auth()->user()->id)->get();

      $finalData = [];

      $amount = 0;

      if(isset($cartitems))
      {
         foreach($cartitems as $cartitem)
         {
            if($cartitem->food)
            {
               foreach($cartitem->food as $orderFood)
               {

                 // var_dump($orderFood);
                  
                  if($orderFood->id == $cartitem->food_id)
                  {
                     $finalData[$cartitem->food_id] ['id'] = $orderFood->id;
                     $finalData[$cartitem->food_id] ['name'] = $orderFood->name;
                     $finalData[$cartitem->food_id] ['quantity'] = $cartitem->quantity;
                     $finalData[$cartitem->food_id] ['price'] = $cartitem->price;
                     $finalData[$cartitem->food_id] ['subtotal'] = $cartitem->price * $cartitem->quantity;
                     $amount += $cartitem->price * $cartitem->quantity;
                     $finalData ['total_Amount'] = $amount;

                  }
               }
            }
         }

         dd($finalData);

      }
      return response()->json($finalData);

     //dd($finalData);
   }

}