<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use App\Models\Album_file;
use Ramsey\Uuid\Type\Integer;

class AlbumController extends Controller
{
    public function upload(Request $request)
    {
        //日付を切り出し
        $date  = $request->date;
        $year  = mb_substr($date, 0, 4);
        $month = mb_substr($date, 5, 2);
        $day   = mb_substr($date, 8, 2);

        //album_no最大値
        $album_no = Album::max('album_no') + 1;

        //albumsテーブルINSERT
        $album = Album::Create([
            'year'       => intval($year),
            'month'      => intval($month),
            'day'        => intval($day),
            'user_id'    => intval($request->id),
            'album_no'   => intval($album_no),
            'address'    => $request->address,
            'title'      => $request->title,
            'comment'    => $request->comment,
        ]);

        $files = $request->file('file');
        foreach ($files as $key => $file) {
            //画像保存
            $file_name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public', $file_name);
            $file_path = str_replace('public', 'storage', $file_path);
            //最初の画像をサムネイルにする
            if ($key === 1) {
                $head_flg = 1;
            } else {
                $head_flg = 0;
            }

            //album_filesテーブルINSERT
            $album_file = Album_file::Create([
                'user_id'    => intval($request->id),
                'album_no'   => intval($album_no),
                'file_path'  => $file_path,
                'file_name'  => $file_name,
                'head_flg'   => $head_flg
            ]);
        };
        $ret = ['album' => $album, 'album_file' => $album_file];
        return $ret;
    }

    public function get(Request $request)
    {
        $album = Album::Join('album_files', 'albums.user_id', '=', 'album_files.user_id')
            ->where('album_files.user_id', $request->id)
            ->where('album_files.head_flg', 1)
            ->get();
        //dd($album);
        return $album;
    }
    public function getDetail(Request $request)
    {
        $album = Album::Join('album_files', 'albums.user_id', '=', 'album_files.user_id')
            ->where('album_files.user_id', $request->user_id)
            ->where('album_files.album_no', $request->album_no)
            ->get();
        //dd($album);
        return $album;
    }




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
}
