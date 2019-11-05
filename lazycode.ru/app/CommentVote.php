<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
