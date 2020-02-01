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
        $response = array(
            'message' => 'Информация о всех комментариях.',
            'comments' => $comments
        );
        return response($response, 200);
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
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }
        $this->validate($request, [
            'post_id' => array(
                'required',
                'integer'
            ),
            'body' => array(
                'required',
                'min:5'
            )
        ]);

        $comment = Comment::create([
            'post_id' => $request['post_id'],
            'author_id' => $user->id,
            'body' => $request['body']
        ]);

        $response = array(
            'message' => 'Комментарий со следующим содержанием - \'' . $request['body'] . '\' - успешно создан!',
            'comment' => $comment
        );

        return response($response, 201);
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $comment = Comment::findOrFail($id);
        if ($comment->author_id == $user->id) {
            $response = array(
                'message' => 'Комментарий со следующим содержанием - \'' . $comment->body . '\' - успешно удалён!'
            );
            $comment->delete();
            return response($response, 200);
        }

        $response = array(
            'message' => 'Доступ к комментарию ограничен.'
        );
        return response($response, 403);
    }
}
