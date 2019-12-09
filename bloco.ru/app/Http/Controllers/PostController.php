<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display all posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select(
            "SELECT
                            p.id            AS post_id,
                            p.title         AS post_title,
                            p.body          AS post_body,
                            p.created_at    AS created_at,
                            u.id            AS user_id,
                            u.username      AS username,
                            u.image         AS user_image,
                            u.username      AS author,
                            c.name          AS category,
                            COUNT(cm.post_id)
                                            AS count_comments,
                            RATING(1, p.id)
                                            AS rating
                    FROM
                            posts p
                    LEFT JOIN comments cm
                            ON p.id = cm.post_id
                    JOIN users u
                            ON p.author_id = u.id
                    JOIN categories c
                            ON p.category_id = c.id
                    GROUP BY p.id, u.id, c.name
                    ORDER BY rating DESC");
        return response($posts, 200);

    }

    /**
     * Store a newly created post in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:300|min:5',
            'category_id' => 'required|integer',
            'author_id' => 'required|integer',
            'body' => 'required|min:10',
        ]);

        $post = Post::create([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'author_id' => $request['author_id'],
            'body' => $request['body']
        ]);

        return response($post, 201);
    }

    /**
     * Display the specified post.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $post = DB::select(
            "SELECT
                            p.id            AS post_id,
                            p.title         AS post_title,
                            p.body          AS post_body,
                            p.created_at    AS created_at,
                            u.id            AS user_id,
                            u.username      AS username,
                            u.image         AS user_image,
                            u.username      AS author,
                            c.name          AS category,
                            COUNT(cm.post_id)
                                            AS count_comments,
                            RATING(1, p.id)
                                            AS rating
                    FROM
                            posts p
                    LEFT JOIN comments cm
                            ON p.id = cm.post_id
                    JOIN users u
                            ON p.author_id = u.id
                    JOIN categories c
                            ON p.category_id = c.id
                    WHERE p.id = ?
                    GROUP BY p.id, u.id, c.name", [$id]);

        return response($post, 200);
    }

    /**
     * Update the specified post in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:300|min:5',
            'category_id' => 'required|integer',
            'author_id' => 'required|integer',
            'body' => 'required|min:10',
        ]);

        $post = Post::findOrFail($id);

        $post->title = $request['title'];
        $post->category_id = $request['category_id'];
        $post->author_id = $request['author_id'];
        $post->body = $request['body'];

        $post->save();

        return response($post, 200);
    }

    /**
     * Remove the specified post from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
         $post = Post::findOrFail($id);
         $post->delete();
         return response($post, 200);
    }

    /**
     * Display all comments of the post.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function postComments(int $id)
    {
        $comments = DB::select(
            "SELECT
                            c.created_at    AS created_at,
                            u.id            AS user_id,
                            u.username      AS username,
                            u.image         AS user_image,
                            c.body          AS comment_body,
                            RATING(2, c.id)
                                            AS rating
                    FROM
                            comments c
                    JOIN posts p
                            ON p.id = c.post_id
                    JOIN users u
                            ON c.author_id = u.id
                    WHERE p.id = ?
                    ORDER BY c.created_at", [$id]);
        return response($comments, 200);
    }
}
