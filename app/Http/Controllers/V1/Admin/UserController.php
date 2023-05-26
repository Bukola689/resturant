<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       if(!$users = User::with('roles')->get()) {
         return response()->json('User Not found');
       }

       if($users->isEmpty()) {
          return response()->json('User Is Empty');
       }

        return UserResource::Collection($users);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|min:3|max:12',
            'lastname' => 'required|string|min:3|max:12',
            'gender' => 'required',
            'occupation' => 'required',
            'phone1' => 'required|int',
            'phone2' => 'required|int',
            'address1' => 'required',
            'address2' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->gender = $request->input('gender');
        $user->occupation = $request->input('occupation');
        $user->phone1 = $request->input('phone1');
        $user->phone2 = $request->input('phone2');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->email = $request->input('email');
        $user->active = true;
        $user->password = Hash::make($request->pasword);
        $user->save();

        Cache::put('user', $user);

        return response()->json([
            'message' => 'User Saved Successfully !',
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if(! $user) {
            return response()->json('User Not Found');
        }

        $showUser = Cache::remember('user:', $user->id, 60, function() use($user) {
            return $user;
        });

        return new UserResource($showUser);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if(! $user) {
            return response()->json('User Not Found');
        }

        $request->validate([
            'firstname' => 'required|string|min:3|max:12',
            'lastname' => 'required|string|min:3|max:12',
            'gender' => 'required',
            'occupation' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'address1' => 'required',
            'address2' => 'required',
        ]);

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->gender = $request->input('gender');
        $user->occupation = $request->input('occupation');
        $user->phone1 = $request->input('phone1');
        $user->phone2 = $request->input('phone2');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->active = true;
        $user->update();

        Cache::put('user', $user);

        return response()->json([
            'message' => 'User Saved Successfully !',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(! $user) {
            return response()->json('User Not Found');
        }

        $user->delete();

        Cache::pull('user');

        return response()->json([
            'message' => 'User Deleted Successfully !'
        ]);
    }

    public function userSearch($search)
    {
        $user = User::where('name', 'LIKE', '%' .$search. '%')->get();

        if($user)
        {
            return response()->json([
                'user' => $user
            ]);
        } else {
            return response()->json(['message' => 'No User Found !']);
        }
    }
}
