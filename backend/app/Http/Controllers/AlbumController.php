<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    public function upload(Request $request)
    {
        //    $files = $request->file;
        $files = $request->file('file');
        foreach ($files as $file) {
            $file_name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public', $file_name);
        }

        $album =
            DB::insert(
                'insert into albums
            (
                year,
                month,
                day,
                user_id,
                album_no,
                user_name,
                album_name,
                comment,
                sakujo_flg,
                created_at,
                updated_at
            ) values (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )',
                [
                    $request->year,
                    $request->month,
                    $request->day,
                    2,
                    2,
                    $file_path,
                    $file_name,
                    'コメントです',
                    0,
                    date("Y/m/d H:i:s"),
                    date("Y/m/d H:i:s")
                ]
            );
        return ['album' => $album];
        // $album_path = DB::table('album_path');

        // $file_name = $request()->file->getClientOriginalName();
        // $request()->file->storeAs('public/',$file_name);

        // $album_a = $album_path->first();
        // $data = $album_a->update(['album_path' => '/storage/'.$file_name]);
        // return $data;
    }
}
