<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller
{
    public function send(request $request) {

        $param =[
            'name'  => $request->name,
            'email' => $request->email
        ];

        $data = [$request->name];

        Mail::send('mail', $data, function ($message) use ($param) {

            $this->send($this->send);
            $message->to($param['email'], $param['name'])
                    ->from('toriton30022@gmail.com','administrator')
                    ->subject('登録完了！');
                //  ->attach(storage_path('app/pdf/test_1.pdf'));
        });
    }
}
