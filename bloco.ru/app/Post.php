<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'category_id', 'author_id', 'body'
    ];

    /**
     * Post's category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * Post's author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    /**
     * Post's comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }

    /**
     * @param int $source_id
     * @param int $type_id
     * @return mixed
     */
    public function rating(int $source_id, int $type_id)
    {
        $vote = Vote::selectRaw('SUM(CASE WHEN vote = TRUE THEN 1 WHEN vote = FALSE THEN -1 ELSE 0 END)')
            ->where('source_id', $source_id)
            ->where('type_id', $type_id)
            ->first();
        return $vote;
    }
}
