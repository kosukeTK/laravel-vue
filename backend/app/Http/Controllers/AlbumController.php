<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use App\Models\Album_file;

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

        $album = Album::Join('album_files', 'albums.user_id', '=', 'album_files.user_id')
            ->where('album_files.album_no', '3')
            ->get();
        dd($album);
        // $album =
        //     DB::insert(
        //         'insert into albums
        //     (
        //         year,
        //         month,
        //         day,
        //         user_id,
        //         album_no,
        //         user_name,
        //         album_name,
        //         comment,
        //         sakujo_flg,
        //         created_at,
        //         updated_at
        //     ) values (
        //         ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        //     )',
        //         [
        //             $request->year,
        //             $request->month,
        //             $request->day,
        //             2,
        //             2,
        //             $file_path,
        //             $file_name,
        //             'コメントです',
        //             0,
        //             date("Y/m/d H:i:s"),
        //             date("Y/m/d H:i:s")
        //         ]
        //     );
        return ['album' => $album];
    }
}
