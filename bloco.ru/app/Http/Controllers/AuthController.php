<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login function.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->first();

        if ($user) {
            if (Hash::check($request['password'], $user->password)) {
                $token = $user->createToken('vmzImL5RrH61OmETEmZZsMabDoQsEi9xjn2tRsIA')->accessToken;
                $response = ['token' => $token, 'data' => $user];
                return response($response, 200);
            } else {
                $response = "Неверный пароль.";
                return response($response, 422);
            }
        } else {
            $response = 'Неверные или несуществующие данные.';
            return response($response, 422);
        }
    }

    /**
     * Register function.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $user = User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken('vmzImL5RrH61OmETEmZZsMabDoQsEi9xjn2tRsIA')->accessToken;
        $response = ['token' => $token, 'data' => $user];

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
        $response = ['answer' => 'Вы успешно вышли из системы!'];
        return response($response, 200);
    }
}
