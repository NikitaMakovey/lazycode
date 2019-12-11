<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Display all votes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $votes = Vote::all();
        return response($votes, 200);
    }

    /**
     * Store or update the specified vote in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_id' => 'required|integer',
            'source_id' => 'required|integer',
            'user_id' => 'required|integer',
            'direct_id' => 'required|integer',
            'vote' => 'required|bool',
        ]);

        if ($request['user_id'] == $request['direct_id']) { return response(['Locked request!'], 422); }

        $vote = Vote::where('type_id', $request['type_id'])
                    ->where('source_id', $request['source_id'])
                    ->where('user_id', $request['user_id'])
                    ->first();

        if ($vote && $vote->vote == $request['vote']) {
            Vote::where('type_id', $request['type_id'])
                ->where('source_id', $request['source_id'])
                ->where('user_id', $request['user_id'])
                ->delete();
            return response(['Successfully deleted!'], 200);
        } else if ($vote) {
            Vote::where('type_id', $request['type_id'])
                ->where('source_id', $request['source_id'])
                ->where('user_id', $request['user_id'])
                ->update(['vote' => $request['vote']]);
            return response(['Successfully updated!'], 200);
        } else {
            Vote::create([
                'type_id' => $request['type_id'],
                'source_id' => $request['source_id'],
                'user_id' => $request['user_id'],
                'direct_id' => $request['direct_id'],
                'vote' => $request['vote']
            ]);
            return response(['Successfully created!'], 201);
        }
    }
}
