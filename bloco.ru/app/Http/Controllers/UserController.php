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
            ->selectRaw(
                'CASE WHEN (
                        (SELECT SUM(vote) FROM votes WHERE direct_id = users.id)
                    ) IS NULL 
                    THEN 0 
                    ELSE (SELECT SUM(vote) FROM votes WHERE direct_id = users.id) 
                END
                    AS sum_votes'
            )
            ->orderBy('sum_votes', 'DESC')
            ->paginate(10);

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
            ->selectRaw(
                '(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)  AS count_comments'
            )
            ->selectRaw(
                '(SELECT SUM(votes.vote) FROM votes WHERE source_id = posts.id AND type_id = 1) AS sum_votes'
            )
            ->orderBy('posts.created_at', 'DESC')
            ->paginate(6);

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
                'comments.body',
                'comments.created_at'
            )
            ->selectRaw(
                '(SELECT SUM(vote) FROM votes WHERE source_id = comments.id AND type_id = 2) AS sum_votes'
            )
            ->orderBy('comments.created_at', 'DESC')
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех комментариях пользователя c ID: ' . $id . '.',
            'comments' => $comments
        );
        return response($response, 200);
    }

    /**
     * Display all posts of the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function publish(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $posts = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where(array(
                'posts.author_id' => $user->id,
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
            ->selectRaw(
                '(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)  AS count_comments'
            )
            ->selectRaw(
                '(SELECT SUM(votes.vote) FROM votes WHERE source_id = posts.id AND type_id = 1) AS sum_votes'
            )
            ->orderBy('posts.created_at', 'DESC')
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех статьях пользователя c ID: ' . $user->id . '.',
            'posts' => $posts
        );
        return response($response, 200);
    }

    /**
     * Display all posts of the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $posts = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where(array(
                'posts.author_id' => $user->id,
                'posts.post_verified_is' => null
            ))
            ->whereRaw(
                'posts.created_at IS NOT NULL'
            )
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
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех статьях пользователя c ID: ' . $user->id . '.',
            'posts' => $posts
        );
        return response($response, 200);
    }

    /**
     * Display all posts of the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $posts = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where(array(
                'posts.author_id' => $user->id,
                'posts.post_verified_is' => false
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
            ->selectRaw(
                '(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)  AS count_comments'
            )
            ->selectRaw(
                '(SELECT SUM(votes.vote) FROM votes WHERE source_id = posts.id AND type_id = 1) AS sum_votes'
            )
            ->orderBy('posts.created_at', 'DESC')
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех статьях пользователя c ID: ' . $user->id . '.',
            'posts' => $posts
        );
        return response($response, 200);
    }

    /**
     * Display all posts of the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function draft(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $posts = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where(array(
                'posts.author_id' => $user->id,
                'posts.post_verified_is' => null
            ))
            ->whereRaw(
                'posts.created_at IS NULL'
            )
            ->select(
                'posts.id',
                'posts.title',
                'posts.image',
                'posts.body',
                'posts.updated_at',
                'categories.name',
                'categories.slug'
            )
            ->orderBy('posts.updated_at', 'DESC')
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех статьях пользователя c ID: ' . $user->id . '.',
            'posts' => $posts
        );
        return response($response, 200);
    }

}
