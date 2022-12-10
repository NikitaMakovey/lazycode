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
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех постах (all).',
            'posts' => $posts
        );
        return response($response, 200);
    }

    /**
     * Update the specified post in storage.
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $db = DB::table('edit_posts')
            ->where(array(
                'post_id' => $id
            ))
            ->first();
        if ($db == null) {
            $response = array(
                'message' => 'Доступ к статье ограничен.'
            );
            return response($response, 403);
        }

        $post = Post::findOrFail($db->post_id);

        if ($post) {
            $post->body = $db->body;
            $post->save();

            DB::table('edit_posts')
                ->where(array(
                    'post_id' => $post->id
                ))
                ->delete();

            $response = array(
                'message' => 'Информация о статье \'' . $post->title . '\' обновлена успешно!',
                'post' => $post
            );
            return response($response, 200);
        }

        $response = array(
            'message' => 'Доступ к статье ограничен.'
        );
        return response($response, 403);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        DB::table('edit_posts')
            ->where(array(
                'post_id' => $id
            ))
            ->delete();

        return response('', 204);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit_posts(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $posts = DB::table('posts')
            ->join('edit_posts', 'posts.id', '=', 'edit_posts.post_id')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->where(array(
                    'posts.post_verified_is' => true
            ))
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
            ->orderBy('edit_posts.created_at')
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех редактируемых постах (all).',
            'posts' => $posts
        );
        return response($response, 200);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $post = DB::table('posts')
            ->join('edit_posts', 'posts.id', '=', 'edit_posts.post_id')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->whereRaw('posts.created_at IS NOT NULL')
            ->where(array(
                'posts.id' => $id
            ))
            ->select(array(
                'posts.id',
                'posts.author_id',
                'posts.title',
                'posts.image',
                'edit_posts.body',
                'posts.created_at',
                'users.username',
                'categories.name',
                'categories.slug',
                'posts.post_verified_is'
            ))
            ->selectRaw(
                'users.image AS user_image'
            )
            ->first();

        if ($post) {
            $response = array(
                'message' => 'Информация о всех редактируемом посте (all).',
                'post' => $post,
            );
            return response($response, 200);
        }

        return response('', 404);
    }
}
