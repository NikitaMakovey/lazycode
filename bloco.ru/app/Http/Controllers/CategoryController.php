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
            $response = array(
                'message' => 'Информация о категории \'' . $category->name . '\'.',
                'category' => $category
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
