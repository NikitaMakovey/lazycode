<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $posts = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->whereRaw('posts.created_at IS NOT NULL')
            ->select(array(
                'posts.id',
                'posts.author_id',
                'posts.title',
                'posts.image',
                'posts.body',
                'posts.created_at',
                'users.username',
                'categories.name',
                'categories.slug',
                'posts.post_verified_is'
            ))
            ->selectRaw(
                'users.image AS user_image'
            )
            ->orderBy('posts.created_at', 'DESC')
            ->get();

        $response = array(
            'message' => 'Информация о всех постах (all).',
            'posts' => $posts
        );
        return response($response, 200);
    }
}
