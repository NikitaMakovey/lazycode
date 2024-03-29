<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        $response = array(
            'message' => 'Информация о всех категориях.',
            'categories' => $categories
        );
        return response($response, 200);
    }

    public function rating()
    {
        $categories = DB::table('categories')
            ->join('posts', 'posts.category_id', '=', 'categories.id')
            ->select(array(
                'categories.id',
                'categories.name',
                'categories.slug'
            ))
            ->selectRaw('COUNT(posts.category_id) AS cat_count')
            ->where(array(
                'posts.post_verified_is' => true
            ))
            ->groupBy(array('categories.id'))
            ->orderBy('cat_count', 'DESC')
            ->limit(6)
            ->get();

        $response = array(
            'message' => 'Информация о всех популярных категориях.',
            'categories' => $categories
        );
        return response($response, 200);
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
            'name' => $request['name'],
            'slug' => Str::slug($request['name'], '_')
        ]);

        $response = array(
            'message' => 'Категория с наименованием \'' . $category->name . '\' успешно создан!',
            'category' => $category
        );
        return response($response, 201);
    }

    /**
     * Display all category's posts.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $posts = DB::table('posts')
                ->join('users', 'posts.author_id', '=', 'users.id')
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->where(array(
                    'posts.post_verified_is' => true,
                    'categories.name' => $category->name
                ))
                ->select(array(
                    'posts.id',
                    'posts.author_id',
                    'posts.title',
                    'posts.image',
                    'posts.body',
                    'posts.created_at',
                    'users.username',
                    'categories.name',
                    'categories.slug'
                ))
                ->selectRaw(
                    'users.image AS user_image'
                )
                ->selectRaw(
                    '(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)  AS count_comments'
                )
                ->selectRaw(
                    '(SELECT SUM(votes.vote) FROM votes WHERE source_id = posts.id AND type_id = 1) AS sum_votes'
                )
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(6);

            $response = array(
                'message' => 'Информация о всех постах категории \'' . $category->name . '\'.',
                'posts' => $posts
            );
            return response($response, 200);
        }
        $response = array(
            'message' => 'Информация о категории не найдена.'
        );
        return response($response, 404);
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

        $response = array(
            'message' => 'Категория \''. $category->name . '\' удалена успешно!'
        );
        $category->delete();
        return response($response, 200);
    }
}
