<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')
            ->select(
                'users.id',
                'users.username',
                'users.name',
                'users.image'
            )
            ->orderBy('users.created_at')
            ->get();

        $response = array(
            'message' => 'Информация о всех пользователях.',
            'users' => $users
        );
        return response($response, 200);
    }

    /**
     * Display the specified user.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);

        $response = array(
            'message' => 'Информация о пользователе \'' . $user->username . '\'.',
            'user' => $user
        );
        return response($response, 200);
    }

    /**
     * Display all posts of the user.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function posts(int $id)
    {
        $posts = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where(array(
                'posts.author_id' => $id,
                'posts.post_verified_is' => true
            ))
            ->select(
                'posts.id',
                'posts.title',
                'posts.image',
                'posts.body',
                'posts.created_at',
                'categories.name',
                'categories.slug'
            )
            ->orderBy('posts.created_at', 'DESC')
            ->get();

        $response = array(
            'message' => 'Информация о всех статьях пользователя c ID: ' . $id . '.',
            'posts' => $posts
        );
        return response($response, 200);
    }

    /**
     * Display all comments of the user.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function comments(int $id)
    {
        $comments = DB::table('comments')
            ->join('posts', 'posts.id', '=', 'comments.post_id')
            ->where(array(
                'comments.author_id' => $id,
                'posts.post_verified_is' => true
            ))
            ->select(
                'posts.id',
                'posts.title',
                'comments.id AS comment_id',
                'comments.body'
            )
            ->orderBy('comments.created_at', 'DESC')
            ->get();

        $response = array(
            'message' => 'Информация о всех статьях пользователя c ID: ' . $id . '.',
            'comments' => $comments
        );
        return response($response, 200);
    }
}
