<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Http\Resources\FoodResource;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use Illuminate\Support\Facades\Cache;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Cache::remember('foods', 60, function () {
           return Food::orderBy('id', 'desc')->paginate(5);
        });

        if($foods->isEmpty()) {
            return response()->json('Food is Empty');
        }

        return FoodResource::collection($foods);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFoodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFoodRequest $request)
    {
        $image = $request->image;
  
        $originalName = $image->getClientOriginalName();
  
        $image_new_name = 'image-' .time() .  '-' .$originalName;
  
        $image->move('foods/image', $image_new_name);

        $food = new Food();
        $food->name = $request->input('name');
        $food->price = $request->input('price');
        $food->quantity = $request->input('quantity');
        $food->image = 'foods/image/' . $image_new_name;
        $food->description = $request->input('description');
        $food->save();

        Cache::put('food', $food);

        return response()->json([
            'food' => $food,
            'message' => 'Food Added successfully !'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food = Food::find($id);

        if(! $food) {
            return response()->json('food id is empty');
        }

        $showFood = Cache::remember('food:', $food->id, 60, function() use($food) {
            return $food;
        });

        return new FoodResource($showFood);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFoodRequest  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFoodRequest $request, $id)
    {
        $food = Food::find($id);

        if(! $food) {
            return response()->json('food id is empty');
        }
        
        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('foods/image', $image_new_name);
  
            $food->image = 'foods/image/' . $image_new_name;
      }

      $food->name = $request->input('name');
      $food->price = $request->input('price');
      $food->quantity = $request->input('quantity');
      $food->description = $request->input('description');
      $food->update();

      Cache::put('food', $food);

      return response()->json([
          'food' => $food,
          'message' => 'Food Updated successfully !'
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Food::find($id);

        if(! $food) {
            return response()->json('food id is empty');
        }

        $food = $food->delete();

        Cache::pull('food');

        return response()->json([
            'message' => 'Food Deleted Successfully !',
            'status' => $food
        ]);
    }

    public function searchFood($search)
    {
        $food = Food::where('name', 'LIKE', '%' .$search. '%')->get();

        return response()->json($food);
    }
}
