<?php

namespace App\Http\Controllers\V1;

use App\Events\Cache\FoodCreated;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Reservation;
use App\Models\Chef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class HomeController extends Controller
{
    //...food...//

    public function allFood()
    {
        //Event::dispatch(new FoodCreated()); 

       // $allFoods = Cache::remember(['foods', 'chef'], 60,  function () {

            $data1 = Food::orderBy('id', 'desc')->get();

             $data2 = Chef::orderBy('id', 'desc')->paginate(5);
        //});
        
        return response()->json([$data1, $data2]);
    }

    public function getFoodById(Food $food)
    {
        $foodId = Cache::rememberr('food:'. $food->id, function () use ($food) {
            return $food;
        });

        return response()->json($foodId);
    }

    public function searchFood($search)
    {
        $food = Food::where('name', 'LIKE', '%' .$search. '%')->get();

        return response()->json($food);
    }


    //...reservation..//

    public function allReservation()
    {
        $reservations = Reservation::orderBy('id', 'desc')->get();

        return response()->json($reservations);
    }

    public function getReservationById(Reservation $reservation)
    {
        return response()->json($reservation);
    }

    public function searchReservation($search)
    {
        $reservation = Reservation::where('name', 'LIKE', '%' .$search. '%')->get();

        if($reservation) {
            return response()->json($reservation);
        } else 
        {
            return response()->json( 'No Record Found !');
        }
    }

    //...chef...//

    public function allchef()
    {
        $allchefs = Reservation::orderBy('id', 'desc')->get();

        return response()->json($allchefs);
    }

    public function getChefById(Chef $chef)
    {
        return response()->json($chef);
    }

    public function searchChef($search)
    {
        $chef = Chef::where('name', 'LIKE', '%' .$search. '%')->get();

        if($chef) {
            return response()->json($chef);
        } else 
        {
            return response()->json( 'No Record Found !');
        }
    }
}
