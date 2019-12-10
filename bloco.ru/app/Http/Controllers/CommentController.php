<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display all comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::all();
        return response($comments, 200);
    }

    /**
     * Store a newly created comment in storage.
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

        return response(['Successfully created!'], 201);
    }

    /**
     * Display the specified comment.
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
     * Remove the specified comment from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response(['Successfully deleted!'], 200);
    }
}
