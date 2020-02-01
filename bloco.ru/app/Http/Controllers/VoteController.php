<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Store or update the specified vote in storage.
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
            'type_id' => 'required|integer',
            'source_id' => 'required|integer',
            'vote' => 'required|integer',
        ]);

        if ($request['vote'] != -1 && $request['vote'] != 1) {
            $response = array(
                'message' => 'Запрос не выполнен - оценка неверного формата.',
                'code' => 0
            );
            return response($response, 403);
        }

        $vote = Vote::where('type_id', $request['type_id'])
                    ->where('source_id', $request['source_id'])
                    ->where('user_id', $user->id)
                    ->first();

        if ($vote == null) {
            if ($request['type_id'] == 1) {
                $post = Post::find($request['source_id']);
                $vote = Vote::create([
                    'type_id' => $request['type_id'],
                    'source_id' => $request['source_id'],
                    'user_id' => $user->id,
                    'direct_id' => $post->author_id,
                    'vote' => (int)$request['vote']
                ]);
            } else {
                $comment = Comment::find($request['source_id']);
                $vote = Vote::create([
                    'type_id' => $request['type_id'],
                    'source_id' => $request['source_id'],
                    'user_id' => $user->id,
                    'direct_id' => $comment->author_id,
                    'vote' => (int)$request['vote']
                ]);
            }

            $response = array(
                'message' => 'Запрос выполнен успешно - оценка поставлена.',
                'code' => $vote->vote
            );
            return response($response, 201);
        } else if ($vote && $vote->vote == $request['vote']) {
            $vote->delete();

            $response = array(
                'message' => 'Запрос выполнен успешно - оценка снята.',
                'code' => 0
            );
            return response($response, 200);
        } else {
            $vote->vote = $request['vote'];
            $vote->save();

            $response = array(
                'message' => 'Запрос выполнен успешно - оценка обновлена.',
                'code' => (int)$vote->vote
            );
            return response($response, 200);
        }
    }
}
