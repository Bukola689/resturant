<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chef;
use App\Http\Resources\ChefResource;
use App\Http\Requests\StoreChefRequest;
use App\Http\Requests\UpdateChefRequest;
use Illuminate\Support\Facades\Cache;

class ChefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Chef::orderBy('id', 'desc')->count();

        $chefs = Cache::remember('chef', 60, function() {
            return Chef::orderBy('id', 'desc')->get();
        });

        if($chefs->isEmpty()) {
            return response()->json('chefs is empty');
        }

        return ChefResource::Collection([$count, $chefs]);
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
     * @param  \App\Http\Requests\StoreChefRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChefRequest $request)
    {
        $image = $request->image;
  
        $originalName = $image->getClientOriginalName();
  
        $image_new_name = 'image-' .time() .  '-' .$originalName;
  
        $image->move('chefs/image', $image_new_name);


        $chef = new Chef();
        $chef->name = $request->input('name');
        $chef->speciality = $request->input('speciality');
        $chef->image = 'chefs/image/' . $image_new_name;
        $chef->save();

        Cache::put('chef', $chef);

        return response()->json([
            'status' => 'Chef Saved Successfully !',
            'message' => $chef
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chef = Chef::find($id);

        if(! $chef) {
            return response()->json('chef id is empty');
        }

        $showChef = Cache::remember('chef:', $chef->id, 60, function() use($chef) {
            return $chef;
        });

        return new ChefResource($showChef);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function edit(Chef $chef)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChefRequest  $request
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChefRequest $request, $id)
    {
        $chef = Chef::find($id);

        if(! $chef) {
            return response()->json('chef id is empty');
        }

        if( $request->hasFile('image')) {
  
            $image = $request->image;
  
            $originalName = $image->getClientOriginalName();
    
            $image_new_name = 'image-' .time() .  '-' .$originalName;
    
            $image->move('chefs/image', $image_new_name);
  
            $chef->image = 'chefs/image/' . $image_new_name;
      }

        $chef->name = $request->input('name');
        $chef->speciality = $request->input('speciality');
        $chef->update();

        Cache::put('chef', $chef);

        return response()->json([
            'status' => 'Chef updated Successfully !',
            'message' => $chef
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chef  $chef
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chef = Chef::find($id);

        if(! $chef) {
            return response()->json('chef id is empty');
        }

        $chef->delete();

        Cache::pull('chef');

        return response()->json([
            'status' => 'Chef Deleted Successfully !',
            'message' => $chef
        ]);
    }

    public function searchChef($search)
    {
        $chef = Chef::where('name', 'LIKE', '%' .$search. '%')->get();

        return response()->json($chef);
    }
}
