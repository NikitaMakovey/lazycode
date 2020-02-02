<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display all posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->where(array(
                'posts.post_verified_is' => true
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
            ->orderBy('posts.created_at', 'DESC')
            ->paginate(6);

        $response = array(
            'message' => 'Информация о всех постах.',
            'posts' => $posts
        );
        return response($response, 200);
    }

    /**
     * Store a newly created post in storage.
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
            'title' => array(
                'required',
                'string',
                'max:300',
                'min:5'
            ),
            'category_id' => array(
                'required',
                'integer'
            ),
            'body' => array(
                'required',
                'min:10'
            ),
            'image' => array(
                'required',
                'string',
                'max:300'
            )
        ]);

        $post = Post::create([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'author_id' => $user->id,
            'body' => $request['body'],
            'image' => $request['image']
        ]);

        $response = array(
            'message' => 'Статья с заголовком \'' . $request['title'] . '\' успешно создан!',
            'post' => $post
        );
        return response($response, 201);
    }

    /**
     * Display the specified post.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $post = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->where(array(
                'posts.post_verified_is' => true,
                'posts.id' => $id
            ))
            ->select(array(
                'posts.id',
                'posts.author_id',
                'posts.title',
                'posts.image',
                'posts.body',
                'posts.created_at',
                'users.username',
                'categories.name'
            ))
            ->selectRaw(
                'users.image AS user_image'
            )
            ->first();
        $comments = $this->getPostComments($id);

        if ($post) {
            $response = array(
                'message' => 'Информация о статье \'' . $post->title . '\'.',
                'post' => $post,
                'comments' => $comments
            );
            return response($response, 200);
        }
        $response = array(
            'message' => 'Информация о статье не найдена.'
        );
        return response($response, 404);
    }

    /**
     * Update the specified post in storage.
     *
     * @param Request $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }
        $this->validate($request, [
            'title' => array(
                'required',
                'string',
                'max:300',
                'min:5'
            ),
            'body' => array(
                'required',
                'min:10'
            ),
        ]);

        $post = Post::findOrFail($id);
        if ($post->author_id == $user->id) {
            $post->title = $request['title'];
            $post->body = $request['body'];
            $post->save();

            $response = array(
                'message' => 'Информация о статье \'' . $post->title . '\' обновлена успешно!',
                'post' => $post
            );
            return response($response, 200);
        }
        $response = array(
            'message' => 'Доступ к статье \'' . $post->title . '\' ограничен.'
        );
        return response($response, 403);
    }

    /**
     * Remove the specified post from storage.
     *
     * @param Request $request
     * @param integer $id
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

        $post = Post::findOrFail($id);
        if ($post->author_id == $user->id) {
            $response = array(
                'message' => 'Информация о статье \'' . $post->title . '\' успешно удалена.'
            );
            $post->delete();
            return response($response, 200);
        }

        $response = array(
            'message' => 'Доступ к статье \'' . $post->title . '\' ограничен.'
        );
        return response($response, 403);
    }

    /**
     * Display all comments of the post.
     *
     * @param int $id
     * @return Collection
     */
    public function getPostComments(int $id) : Collection
    {
        $comments = DB::table('comments')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->join('users', 'comments.author_id', '=', 'users.id')
            ->where(array(
                'posts.id' => $id
            ))
            ->select(array(
                'comments.id',
                'comments.created_at',
                'comments.body',
                'users.username',
                'users.image',
            ))
            ->selectRaw('users.id AS user_id')
            ->orderBy('comments.created_at', 'DESC')
            ->get();

        return $comments;
    }

    /**
     * @param int $id
     * @return integer
     */
    public function votes(int $id) : int
    {
        $votes = DB::table('votes')
            ->join('vote_types', 'votes.type_id', '=', 'vote_types.id')
            ->where(array(
                'vote_types.type' => 'post',
                'votes.source_id' => $id
            ))
            ->sum('votes.vote');

        return $votes;
    }
}
