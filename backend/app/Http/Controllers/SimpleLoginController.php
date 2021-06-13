<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SimpleLoginController extends Controller
{
    public function guestLogin(Request $request) {

        $guestUser = User::where('id', $request->id)->get();
        $ret = ['guest' => $guestUser];
        return response()->json($ret);
    }
}
