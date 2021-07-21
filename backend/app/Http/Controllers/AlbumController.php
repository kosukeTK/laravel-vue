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
        //日付を切り出し
        $date  = $request->date
        $year  = mb_substr($date, 4)
        $month = mb_substr($date, 5, 2)
        $day   = mb_substr($date, 8, 2)
        
        //album_no最大値
        $album_no = $Album::max('album_no') + 1;
        
        //albumsテーブルINSERT
        $album = $Album::forceCreate([
            'year'		=> $year,
            'month'		=> $month,
            'day'		=> $day,
            'user_id'	=> $request->id,
            'album_no'	=> $album_no,
            'title'		=> $request->title,
            'comment'	=> $request->comment,
        ]);
        
        $files = $request->file('file');
        foreach ($files as $file) {
        	//画像保存
            $file_name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public', $file_name);
            
            //album_filesテーブルINSERT
            $album_file = Album_file::forceCreate([
            	'user_id'	=> $request->id,
            	'album_no'	=> $album_no,
            	'file_name'	=> $file_name,
            	'file_path' => $file_path
            ])
        }
        $ret = ['album' => $album, 'album_file' => $album_file]
		return $ret
    }

    public function get(Request $request) {
        $album = Album::Join('album_files', 'albums.user_id', '=', 'album_files.user_id')
            ->where('album_files.user_id', $request->id)
            ->get();
        dd($album);
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
