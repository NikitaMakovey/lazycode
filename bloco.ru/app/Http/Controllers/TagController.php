<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        $response = array(
            'message' => 'Информация о всех тегах.',
            'tags' => $tags
        );
        return response($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => array(
                'required',
                'string',
                'max:255',
                'unique:tags'
            )
        ));

        $tag = Tag::create([
            'name' => $request['name']
        ]);

        $response = array(
            'message' => 'Тег с наименованием \'' . $tag->name . '\' успешно создан!',
            'category' => $tag
        );
        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $tag = Tag::findOrFail($id);

        $response = array(
            'message' => 'Тег \''. $tag->name . '\' удалён успешно!'
        );
        $tag->delete();
        return response($response, 200);
    }
}
