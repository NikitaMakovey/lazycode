<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function store(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $author = User::findOrFail($id);

        if ($user->id == $author->id) {
            $response = array(
                'message' => 'Пользователь не имеет возможности подписываться на самого себя.'
            );
            return response($response, 403);
        }

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'author_id' => $author->id
        ]);

        $response = array(
            'message' =>
                'Пользователь ' . $user->username .
                ' успешно подписался на пользователя ' . $author->username .'.',
            'subscription' => $subscription
        );
        return response($response, 201);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function subscribers(int $id)
    {
        $subscribers = DB::table('subscriptions')
            ->join('users', 'subscriptions.user_id', '=', 'users.id')
            ->where(array(
                'subscriptions.author_id' => $id
            ))
            ->select(array(
                'users.id',
                'users.name',
                'users.username',
                'users.image'
            ))
            ->orderBy('subscriptions.id')
            ->get();

        $response = array(
            'message' => 'Информация о всех подписчиках пользователя c ID: ' . $id . '.',
            'subscribers' => $subscribers
        );
        return response($response, 200);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function subscriptions(int $id)
    {
        $subscriptions = DB::table('subscriptions')
            ->join('users', 'subscriptions.author_id', '=', 'users.id')
            ->where(array(
                'subscriptions.user_id' => $id
            ))
            ->select(array(
                'users.id',
                'users.name',
                'users.username',
                'users.image'
            ))
            ->orderBy('subscriptions.id')
            ->get();

        $response = array(
            'message' => 'Информация о всех подписках пользователя с ID: ' . $id . '.',
            'subscriptions' => $subscriptions
        );
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
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

        $sub = Subscription::where('author_id', $id)
            ->where('user_id', $user->id)
            ->first();


        $response = array(
            'message' => 'Подписка на пользователя с ID: \''. $sub->author_id . '\' удалена успешно!'
        );
        $sub->delete();
        return response($response, 200);
    }
}
