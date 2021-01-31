<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistController extends Controller
{
    public function reg(Request $request)
    {
        return ['user' => 'とまとさん豪'];
    }
}
