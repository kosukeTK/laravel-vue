<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function albumInfo(Request $request)
    {
        $param = [
            'year'  => $request->year,
            'month' => $request->month
        ];

        $album =
            DB::select(
                'SELECT *
            FROM   albums
            WHERE  year  =:year
            AND    month =:month',
                $param
            );

        return ['album' => $album];
    }
}
