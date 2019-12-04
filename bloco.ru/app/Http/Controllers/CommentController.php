<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();

        return response($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|integer',
            'author_id' => 'required|integer',
            'body' => 'required|min:10',
        ]);

        $comment = Comment::create([
            'post_id' => $request['post_id'],
            'author_id' => $request['author_id'],
            'body' => $request['body']
        ]);

        return response($comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $comment = Comment::findOrFail($id);

        return response($comment, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response($comment, 200);
    }
}
