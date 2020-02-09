<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function main(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        if ($request['username'] != $user->username) {
            $this->validate($request, [
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
                )
            ]);
        } else {
            $this->validate($request, [
                'name' => array(
                    'required',
                    'string',
                    'max:255'
                )
            ]);
        }

        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->save();

        $response = array(
            'message' => 'Информация успешно обновлена!',
            'user' => $user
        );
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function image(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $this->validate($request, array(
            'image' => array(
                'required',
                'string',
                'max:300'
            )
        ));

        $user->image = $request['image'];
        $user->save();

        $response = array(
            'message' => 'Информация успешно обновлена!',
            'user' => $user
        );
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function email(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $this->validate($request, array(
            'email' => array(
                'required',
                'string',
                'max:255',
                'email',
                'unique:users'
            )
        ));

        if ($user->email != $request['email']) {
            $user->email_verified_at = null;
        }
        $user->email = $request['email'];
        $user->save();

        $response = array(
            'message' => 'Информация успешно обновлена!',
            'user' => $user
        );
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function bio(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $this->validate($request, array(
            'specialization' => array(
                'required',
                'string',
                'max:255'
            ),
            'about' => array(
                'required'
            ),
        ));

        $user->specialization = $request['specialization'];
        $user->about = $request['about'];
        $user->save();

        $response = array(
            'message' => 'Информация успешно обновлена!',
            'user' => $user
        );
        return response($response, 200);
    }
}
