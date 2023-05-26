<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(User $user)
    {
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout Successfully !'
        ]);
    }
}
