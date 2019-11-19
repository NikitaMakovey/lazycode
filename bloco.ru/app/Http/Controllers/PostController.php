<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
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
