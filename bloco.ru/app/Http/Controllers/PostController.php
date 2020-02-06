<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
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
            ->selectRaw(
                '(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)  AS count_comments'
            )
            ->selectRaw(
                '(SELECT SUM(votes.vote) FROM votes WHERE source_id = posts.id AND type_id = 1) AS sum_votes'
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
            ),
            'tags' => array(
                'required',
                'array'
            )
        ]);

        $post = Post::create([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'author_id' => $user->id,
            'body' => $request['body'],
            'image' => $request['image']
        ]);

        $this->insert_tags($request['tags'], $post->id);

        $response = array(
            'message' => 'Статья с заголовком \'' . $request['title'] . '\' успешно создан!',
            'post' => $post
        );
        return response($response, 201);
    }

    /**
     * Store a newly created post in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function draft(Request $request)
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
            ),
            'tags' => array(
                'nullable',
                'array'
            )
        ]);

        $post = Post::create([
            'title' => $request['title'],
            'category_id' => $request['category_id'],
            'author_id' => $user->id,
            'body' => $request['body'],
            'image' => $request['image']
        ]);
        $post->created_at = null;
        $post->save();

        $this->delete_tags($post->id);
        $this->insert_tags($request['tags'], $post->id);

        $response = array(
            'message' => 'Статья с заголовком \'' . $request['title'] . '\' успешно занесён в черновик!',
            'post' => $post
        );
        return response($response, 201);
    }

    /**
     * @param array $tags
     * @param int $id
     */
    private function insert_tags(array $tags, int $id)
    {
        for ($i = 0; $i < count($tags); $i++) {
            $tag = DB::table('tags')
                ->where(array(
                    'name' => strtoupper($tags[$i])
                ))
                ->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => strtoupper($tags[$i])
                ]);
            }

            $ex = DB::table('post_tag')
                ->where(array(
                    'post_id' => $id,
                    'tag_id' => $tag->id
                ))
                ->first();

            if (!$ex) {
                DB::table('post_tag')
                    ->insert(array(
                        'post_id' => $id,
                        'tag_id' => $tag->id
                    ));
            }
        }
    }

    /**
     * @param int $id
     */
    private function delete_tags(int $id)
    {
        DB::table('post_tag')
            ->where(array(
                'post_id' => $id
            ))
            ->delete();
    }

    /**
     * Store a newly created post in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_draft(Request $request, int $id)
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
            ),
            'tags' => array(
                'nullable',
                'array'
            )
        ]);


        $post = Post::findOrFail($id);
        if ($post->author_id === $user->id) {

            $post->title = $request['title'];
            $post->category_id = $request['category_id'];
            $post->body = $request['body'];
            $post->image = $request['image'];
            $post->created_at = null;
            $post->save();

            $this->delete_tags($post->id);
            $this->insert_tags($request['tags'], $post->id);

            $response = array(
                'message' => 'Черновик с заголовком \'' . $request['title'] . '\' успешно обновлён!',
                'post' => $post
            );
            return response($response, 200);
        }

        $response = array(
            'message' => 'Доступ запрещён.'
        );
        return response($response, 403);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete_draft(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $post = Post::findOrFail($id);
        if ($post->author_id === $user->id) {
            $this->delete_tags($post->id);
            $post->delete();

            $response = array(
                'message' => 'Черновик успешно удалён!',
            );
            return response($response, 200);
        }

        $response = array(
            'message' => 'Доступ запрещён.'
        );
        return response($response, 403);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function auth_show(Request $request, int $id)
    {
        $user = $request->user();
        if ($user == null) {
            $response = array(
                'message' => 'Пользователь не аутентифицирован.'
            );
            return response($response, 401);
        }

        $post = $this->getPost($id);
        $comments = $this->getAuthPostComments($id, $user->id);
        $tags = $this->getPostTags($id);
        $clicked = $this->getVoteStatus($id, $user->id);

        if ($post) {
            $response = array(
                'message' => 'Информация о статье \'' . $post->title . '\'.',
                'post' => $post,
                'tags' => $tags,
                'comments' => $comments,
                'clicked' => $clicked
            );
            return response($response, 200);
        }
        $response = array(
            'message' => 'Информация о статье не найдена.'
        );
        return response($response, 404);
    }

    /**
     * @param int $post_id
     * @param int $user_id
     * @return int
     */
    private function getVoteStatus(int $post_id, int $user_id) : int
    {
        $vote = DB::table('votes')
            ->where(array(
                'type_id' => 1,
                'source_id' => $post_id,
                'user_id' => $user_id
            ))
            ->select(array(
                'vote'
            ))
            ->first();

        if ($vote) {
            return $vote->vote;
        }
        return 0;
    }

    /**
     * Display the specified post.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $post = $this->getPost($id);
        $comments = $this->getPostComments($id);
        $tags = $this->getPostTags($id);

        if ($post) {
            $response = array(
                'message' => 'Информация о статье \'' . $post->title . '\'.',
                'post' => $post,
                'tags' => $tags,
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
     * Display the specified post.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $post = $this->getEditPost($id);
        $tags = $this->getPostTags($id);

        if ($post) {
            $response = array(
                'message' => 'Информация о статье \'' . $post->title . '\'.',
                'post' => $post,
                'tags' => $tags
            );
            return response($response, 200);
        }
        $response = array(
            'message' => 'Информация о статье не найдена.'
        );
        return response($response, 404);
    }

    private function getEditPost(int $id)
    {
        $post = DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->where(array(
                'posts.id' => $id
            ))
            ->select(array(
                'posts.id',
                'posts.author_id',
                'posts.title',
                'posts.image',
                'posts.body',
                'categories.name',
                'categories.id AS category_id'
            ))
            ->first();

        return $post;
    }
    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    private function getPost(int $id)
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
            ->first();

        return $post;
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
            'body' => array(
                'required',
                'min:10'
            ),
        ]);

        $post = Post::findOrFail($id);
        if ($post->author_id == $user->id) {
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
                'comments.author_id',
                'users.username',
                'users.image',
                'users.name',
            ))
            ->selectRaw(
                '(SELECT SUM(vote) FROM votes WHERE source_id = comments.id AND type_id = 2) AS sum_votes'
            )
            ->selectRaw(
                '0 AS code'
            )
            ->orderBy('comments.created_at', 'DESC')
            ->get();

        return $comments;
    }

    /**
     * @param int $post_id
     * @param int $user_id
     * @return Collection
     */
    public function getAuthPostComments(int $post_id, int $user_id) : Collection
    {
        $comments = DB::table('comments')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->join('users', 'comments.author_id', '=', 'users.id')
            ->where(array(
                'posts.id' => $post_id
            ))
            ->select(array(
                'comments.id',
                'comments.created_at',
                'comments.body',
                'comments.author_id',
                'users.username',
                'users.image',
                'users.name',
            ))
            ->selectRaw(
                '(SELECT SUM(vote) FROM votes WHERE source_id = comments.id AND type_id = 2) AS sum_votes'
            )
            ->selectRaw(
                '(SELECT votes.vote FROM votes 
                WHERE source_id = comments.id AND type_id = 2 AND user_id = ?) 
                AS code', [$user_id]
            )
            ->orderBy('comments.created_at', 'DESC')
            ->get();

        return $comments;
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getPostTags(int $id) : Collection
    {
        $tags = DB::table('post_tag')
            ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
            ->where(array(
                'post_tag.post_id' => $id
            ))
            ->select(array(
                'tags.id',
                'tags.name'
            ))
            ->get();

        return $tags;
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
