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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::select("SELECT 
                    DISTINCT p.id AS post_id,
                    p.title AS post_title,
                    p.body AS post_body,
                    p.created_at AS created_at,
                    c.name AS category,
                    u.id AS user_id,
                    u.username AS username,
                    u.image AS user_image,
                    u.username AS author, 
                    c.name AS category, 
                    SUM(CASE WHEN v.vote = TRUE THEN 1 WHEN v.vote = FALSE THEN -1 ELSE 0 END) 
                        OVER(PARTITION BY v.source_id) AS rating,
                    COUNT(cm.post_id) OVER(PARTITION BY cm.post_id) AS count_comments
                    FROM 
                        posts p 
                    JOIN users u 
                        ON p.author_id = u.id
                    JOIN categories c 
                        ON c.id = p.category_id
                    LEFT JOIN votes v 
                        ON v.source_id = p.id and v.type_id = 1
                    LEFT JOIN comments cm 
                        ON cm.post_id = p.id
                    ORDER BY p.created_at DESC");
        return response($query, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:300|min:5',
            'category_id' => 'required|integer',
            'author_id' => 'required|integer',
            'body' => 'required|min:10',
        ]);

        return Post::create([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'author_id' => $request['author_id'],
            'body' => $request['body']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Post::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:300|min:5',
            'category_id' => 'required|integer',
            'author_id' => 'required|integer',
            'body' => 'required|min:10',
        ]);

        $post = Post::find($id);

        $post->title = $request['title'];
        $post->category_id = $request['category_id'];
        $post->author_id = $request['author_id'];
        $post->body = $request['body'];

        $post->save();

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
         $post = Post::findOrFail($id);

         $post->delete();

         return $post;
    }
}
