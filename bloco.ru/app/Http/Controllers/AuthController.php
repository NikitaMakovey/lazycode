<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login function.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'remember_me' => 'boolean'
        ]);

        $user = User::where('email', $request['email'])->first();

        if ($user) {
            if (Hash::check($request['password'], $user->password)) {

                $tokenResult = $user->createToken(env('PASSPORT_CLIENT_SECRET'));
                $token = $tokenResult->token;

                if ($request['remember_me']) {
                    $token->expires_at = Carbon::now()->addMinutes(30);
                }

                $token->save();

                $response = array(
                    'access_token' => 'Bearer ' . $tokenResult->accessToken,
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString(),
                    'now_datetime' => date('Y-m-d h:i:s'),
                    'user' => $user
                );
                return response($response, 200);
            } else {
                $response = array(
                    'message' => 'Неверный пароль.',
                    'errors' => array(
                        'password' => 'Неверный пароль'
                    )
                );
                return response($response, 401);
            }
        } else {
            $response = array(
                'message' => 'Неверный email или пароль.'
            );
            return response($response, 422);
        }
    }

    /**
     * Register function.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request, array(
            'name' => array(
                'required',
                'string',
                'max:255'
            ),
            'username' => array(
                'required',
                'string',
                'max:255',
                'alpha_dash',
                'unique:users'
            ),
            'email' => array(
                'required',
                'string',
                'max:255',
                'email',
                'unique:users'
            ),
            'password' => array(
                'required',
                'string',
                'confirmed',
                'min:8'
            )
        ));

        User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $response = array('message' => 'Регистрация прошла успешно!');
        return response($response, 201);
    }

    /**
     * Logout function.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $response = array('message' => 'Успешно выполнен выход с платформы!');
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        return response($request->user(), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function isAdmin(Request $request)
    {
        $user = $request->user();

        if ($user->username == 'makovey_nikita') {
            $user->is_admin = true;
            $user->save();

            $response = array(
                'message' => 'Проверка прошла успешно!',
                'is_admin' => $user->is_admin
            );
            return response($response, 200);
        }

        $response = array(
            'message' => 'Проверка не была пройдена!'
        );
        return response($response, 403);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirmEmail(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Not Auth'
            );
            return response($response, 401);
        }

        $this->validate($request, [
            'code' => array(
                'required'
            )
        ]);

        $code = str_replace("%2F", "/", $request['code']);
        $str_code = '$2y$10$' . $code;

        if (Hash::check($user->email, $str_code)) {
            $user->email_verified_at = date('Y-m-d h:i:s');
            $user->save();
            $response = array(
                'message' => 'Аккаунт подтверждён!'
            );
            return response($response, 200);
        }

        $response = array(
            'message' => 'Аккаунт не подтверждён!'
        );
        return response($response, 403);
    }
}
