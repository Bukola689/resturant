<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Cache::remember('reservation', 60, function() {
            return  Reservation::orderBy('id', 'desc')->get();
        }); 

        if($reservations->isEmpty()) {
            return response()->json('Reservation Is Empty');
        }

        return ReservationResource::collection($reservations);
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
     * @param  \App\Http\Requests\StoreReservationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservationRequest $request)
    {
       $reservation = new Reservation();
       $reservation->name = $request->input('name');
       $reservation->email = $request->input('email');
       $reservation->phone = $request->input('phone');
       $reservation->guest = $request->input('guest');
       $reservation->date = $request->input('date');
       $reservation->time = $request->input('time');
       $reservation->message = $request->input('message');
       $reservation->save();

       Cache::put('reservation', $reservation);

       return response()->json([
        'status' => 'Reservation Saved Successfully',
        'reservation' => $reservation
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::find($id);

        if(! $reservation) {
            return response()->json('Reservation id not found');
        }

        $showReservation = Cache::remember('reservation:', 60, function() use($reservation) {
            return $reservation;
        });

        return new ReservationResource($$showReservation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReservationRequest  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservationRequest $request, $id)
    {
        $reservation = Reservation::find($id);

        if(! $reservation) {
            return response()->json('Reservation id not found');
        }

        $reservation->name = $request->input('name');
        $reservation->email = $request->input('email');
        $reservation->phone = $request->input('phone');
        $reservation->guest = $request->input('guest');
        $reservation->date = $request->input('date');
        $reservation->time = $request->input('time');
        $reservation->message = $request->input('message');
        $reservation->update();

        Cache::put('reservation', $reservation);
 
        return response()->json([
         'status' => 'Reservation Updated Successfully',
         'reservation' => $reservation
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if(! $reservation) {
            return response()->json('Reservation id not found');
        }

        $reservation->delete();

        Cache::pull('reservation');

        return response()->json([
            'status' => 'Reservation Deleted Successfully !',
            'message' => $reservation
        ]);
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
}
