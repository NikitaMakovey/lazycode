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
        $users = DB::select(
            "SELECT 
                        DISTINCT u.id AS user_id,
                        u.username AS username,
                        u.name AS name,
                        u.image AS user_image,
                        SUM(CASE WHEN v.vote = TRUE THEN 1 WHEN v.vote = FALSE THEN -1 ELSE 0 END) 
                            OVER(PARTITION BY v.direct_id) AS rating
                    FROM 
                        users u
                    LEFT JOIN votes v
                        ON v.direct_id = u.id
                    ORDER BY rating DESC");
        return response($users, 200);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user =  User::create([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'about' => $request['about'],
            'password' => Hash::make($request['password'])
        ]);

        return response($user, 201);
    }

    /**
     * Display the specified user.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = DB::select(
            "SELECT 
                        DISTINCT u.id AS user_id,
                        u.username AS username,
                        u.specialization AS specialization,
                        u.about AS about,
                        u.name AS name,
                        u.image AS user_image,
                        SUM(CASE WHEN v.vote = TRUE THEN 1 WHEN v.vote = FALSE THEN -1 ELSE 0 END) 
                            OVER(PARTITION BY v.direct_id) AS rating
                    FROM 
                        users u
                    LEFT JOIN votes v
                        ON v.direct_id = u.id
                    WHERE u.id = ?", [$id]);

        return response($user, 200);
    }

    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'about' => 'nullable',
        ]);

        $user = User::find($id);

        if ($request['name']) $user->name = $request['name'];
        if ($request['specialization']) $user->specialization = $request['specialization'];
        if ($request['image']) $user->image = $request['image'];
        if ($request['about']) $user->about = $request['about'];

        $user->save();

        return response($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response($user, 200);
    }

    /**
     * Display all posts of the user.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function userPosts(int $id)
    {
        $posts = DB::select(
            "SELECT
                            p.id            AS post_id,
                            p.title         AS post_title,
                            p.body          AS post_body,
                            p.created_at    AS created_at,
                            u.id            AS user_id,
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
                    WHERE u.id = ?
                    GROUP BY p.id, u.id, c.name", [$id]);
        return response($posts, 200);
    }

    /**
     * Display all comments of the user.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function userComments(int $id)
    {
        $comments = DB::select(
            "SELECT
                            p.id            AS post_id,
                            p.title         AS post_title,
                            u.id            AS user_id,
                            u.username      AS username,
                            u.image         AS user_image,
                            c.body          AS comment_body,
                            c.id            AS comment_id,
                            RATING(2, c.id)
                                            AS rating
                    FROM
                            comments c
                    JOIN posts p
                            ON p.id = c.post_id
                    JOIN users u
                            ON c.author_id = u.id
                    WHERE u.id = ?", [$id]);
        return response($comments, 200);
    }
}
