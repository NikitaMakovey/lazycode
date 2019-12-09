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
                    ->get();

        //return response(count($vote), 200);

        if (!count($vote)) {
            DB::insert(
                "INSERT INTO votes (type_id, source_id, user_id, direct_id, vote, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, current_timestamp, current_timestamp) 
                    ON CONFLICT (type_id, source_id, user_id) DO NOTHING",
                [
                    $request['type_id'],
                    $request['source_id'],
                    $request['user_id'],
                    $request['direct_id'],
                    $request['vote']
                ]);

            return response(['Successfully created!'], 201);
        } else {
            DB::update(
                "UPDATE votes SET vote = ? AND updated_at = current_timestamp
                    WHERE type_id = ? AND source_id = ? AND user_id = ?",
                [
                    $request['vote'],
                    $request['type_id'],
                    $request['source_id'],
                    $request['user_id']
                ]);

            return response(['Successfully updated!'], 200);
        }
    }

    /**
     * Remove the specified vote from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vote = Vote::where('type_id', $request['type_id'])
                    ->where('source_id', $request['source_id'])
                    ->where('user_id', $request['user_id']);
        $vote->delete();
        return response(['Successfully deleted'], 200);
    }
}
