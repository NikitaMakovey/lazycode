<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationMailBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendConfirmationEmail(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Not Auth'
            );
            return response($response, 401);
        }

        $root_link = 'http://localhost:8000';
        $code = Hash::make($user->email);
        $str_code = mb_strimwidth($code, 7, strlen($code) - 7);
        $link = $root_link . '/confirm/';
        $data = array(
            'name' => $user->name,
            'link' => $link,
            'code' => $str_code
        );

        Mail::to($user->email)->send(new ConfirmationMailBuilder($data));

        $response = array(
            'message' => 'Успешно отослано сообщение!'
        );
        return response($response, 200);
    }
}
