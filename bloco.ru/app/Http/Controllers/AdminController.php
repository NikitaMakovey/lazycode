<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $post = Post::findOrFail($id);
        $post->post_verified_is = true;
        $post->save();

        return response('', 204);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $post = Post::findOrFail($id);
        $post->post_verified_is = false;
        $post->save();

        return response('', 204);
    }
}
