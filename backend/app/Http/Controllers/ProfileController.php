<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function get(Request $request)
    {
        $form = User::where('id', $request->id)->first();
        return $form;
    }

    public function update(Request $request)
    {
        // $called = app()->make('App\Http\Controllers\Auth\RegisterController');
        // $register = $called->register($request);

        //写真
        $file = $request->file('file');
        if (isset($file)) {
            $file->storeAs('public/' . strval($request->id), $request->photo);
            $filePath = 'storage/' . strval($request->id) . '/' . $request->photo;
        } else {
            $filePath = $request->photo_path;
        }
        //カバー写真
        $cfile = $request->file('cfile');
        if (isset($cfile)) {
            $cfile->storeAs('public/' . strval($request->id), $request->photo_cover);
            $cfilePath = 'storage/' . strval($request->id) . '/' . $request->photo_cover;
        } else {
            $cfilePath = $request->photo_cover_path;
        }
        User::where('id', $request->id)->update([
            'name'  => $request->name,
            'email' => $request->email,
            'prefectures'   => $request->prefectures,
            'city'  => $request->city,
            'photo' => $request->photo,
            'photo_path'    => $filePath,
            'photo_cover'   => $request->photo_cover,
            'photo_cover_path'   => $cfilePath
        ]);



        return;
    }
}
