<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationMailBuilder;
use App\Mail\ResetPasswordMailBuilder;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendResetEmail(Request $request)
    {
        $this->validate($request, [
            'email' => array(
                'required',
                'email',
                'string'
            )
        ]);

        $user = User::where('email', $request['email'])->first();
        if ($user) {
            $root_link = 'http://localhost:8000';

            $code = Hash::make($user->email);
            $str_code = mb_strimwidth($code, 7, strlen($code) - 7);

            $tokenResult = $user->createToken(env('PASSPORT_CLIENT_SECRET'));
            $token = $tokenResult->accessToken;
            $str_token = mb_strimwidth($token, 0, 300);
            $tokenResult->token->revoke();

            DB::table('password_resets')
                ->where(array(
                    'email' => $user->email
                ))
                ->delete();

            DB::table('password_resets')
                ->insert(array(
                    'email' => $user->email,
                    'token' => $str_token
                ));

            $link = $root_link . '/reset/';
            $data = array(
                'name' => $user->name,
                'link' => $link,
                'code' => $str_code,
                'token' => $str_token
            );

            Mail::to($user->email)->send(new ResetPasswordMailBuilder($data));

            $response = array(
                'message' => 'Проверьте Ваш E-mail!'
            );
            return response($response, 200);
        }

        $response = array(
            'message' => 'Несуществующий E-mail!'
        );
        return response($response, 402);
    }
}
