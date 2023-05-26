<?php

namespace App\Http\Controllers\V1\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'address1' => 'required',
            'address2' => 'required',
            'email' => 'required|same:email'
        ]);
      
        $order = new Order();
        $order->firstname = $request->input('firstname');
        $order->lastname = $request->input('lastname');
        $order->occupation = $request->input('occupation');
        $order->gender = $request->input('gender');
        $order->phone1 = $request->input('phone1');
        $order->phone2 = $request->input('phone2');
        $order->address1 = $request->input('address1');
        $order->address2 = $request->input('address2');
        $order->email = $request->input('email');
        $order->save();
       
        $cartitems = Cart::where('user_id', Auth::id())->get();
        foreach($cartitems as $item)
        {
            Orderitem::create([
                'order_id' => $order->id,
                'food_id' => $item->food_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }
        
            if(Auth::user()->address1 == null )
            {
                $user = User::where('id', Auth::id())->first();
                $user->firstname = $request->input('firstname');
                $user->lastname = $request->input('lastname');
                $user->gender = $request->input('gender');
                $user->occupation = $request->input('occupation');
                $user->phone1 = $request->input('phone1');
                $user->phone2 = $request->input('phone2');
                $user->address1 = $request->input('address1');
                $user->address2 = $request->input('address2');
                $user->update();
            }

            return response()->json([
                'status' => true,
                'message' => $order,
            ]);
         
    } 
}
