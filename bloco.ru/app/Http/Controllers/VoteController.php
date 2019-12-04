<?php

namespace App\Http\Controllers;

use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $votes = Vote::all();
        return response($votes, 200);
    }

    /**
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

        $v = $request['vote'] == 0 ? FALSE : TRUE;

//        $vote = Vote::create([
//            'type_id' => $request['type_id'],
//            'source_id' => $request['source_id'],
//            'user_id' => $request['user_id'],
//            'direct_id' => $request['direct_id'],
//            'vote' => $v,
//        ]);

        if ($request['user_id'] == $request['direct_id']) { return response(['Locked request!'], 422); }

        DB::insert(
    "INSERT INTO votes (type_id, source_id, user_id, direct_id, vote)
            VALUES(?, ?, ?, ?, ?) ON CONFLICT(type_id, source_id, user_id) DO NOTHING",
            [
                $request['type_id'],
                $request['source_id'],
                $request['user_id'],
                $request['direct_id'],
                $v
            ]);
        return response(['Successfully created!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
       //
    }
}
