<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(CommentVote::class);
    }

    public function remove()
    {
        $this->delete();
    }
}
