<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = ['title', 'post_body'];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function votes()
    {
        return $this->hasMany(PostVote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->save();
        return $post;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        //Storage::delete('uploads/' . $this->image);
        //$this->delete();
    }

    public function setCategory($id)
    {
        if ($id == null) { return; }
        //$category = Category::find($id);
        //$this->category()->save($category);
    }

    public function setAuthor($id)
    {
        if ($id == null) { return; }
        //$author = User::find($id);
        //$this->author()->save($author);
    }

    public function uploadImage($image)
    {
//        if ($image == null) { return; }
//        Storage::delete('uploads/' . $this->image);
//        $filename = Str::random(60) . '.' . $image->extension();
//        $image->saveAs('uploads', $filename);
//        //$this->image = $filename;
//        $this->save();
    }

    public function getImage()
    {
        //if ($this->image == null) { return '/img/no_img_post.jpg'; }
        //return '/uploads/' . $this->image;
    }
}
