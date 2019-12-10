<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response($categories, 200);
    }

    /**
     * Store a newly created category in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:categories'
        ]);

        $category = Category::create([
            'name' => $request['name']
        ]);

        return response(['Successfully created!'], 201);
    }

    /**
     * Display all category's posts.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $posts = DB::select(
            "SELECT
                            p.id            AS post_id,
                            p.title         AS post_title,
                            p.body          AS post_body,
                            p.created_at    AS created_at,
                            u.id            AS user_id,
                            u.username      AS username,
                            u.image         AS user_image,
                            u.username      AS author,
                            c.name          AS category,
                            COUNT(cm.post_id)
                                            AS count_comments,
                            RATING(1, p.id)
                                            AS rating
                    FROM
                            posts p
                    LEFT JOIN comments cm
                            ON p.id = cm.post_id
                    JOIN users u
                            ON p.author_id = u.id
                    JOIN categories c
                            ON p.category_id = c.id
                    WHERE c.id = ?
                    GROUP BY p.id, u.id, c.name
                    ORDER BY rating DESC", [$id]);
        return response($posts, 200);
    }


    /**
     * Update category's name.
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:categories'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request['name'];
        $category->save();

        return response(['Successfully updated!'], 200);
    }

    /**
     * Remove the specified category from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response(['Successfully deleted!'], 200);
    }
}
