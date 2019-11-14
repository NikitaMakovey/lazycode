<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postVotes()
    {
        return $this->hasMany(PostVote::class);
    }

    public function commentVotes()
    {
        return $this->hasMany(CommentVote::class);
    }

    public static function add($field)
    {
//        $user = new static;
//        $user->fill($field);
//        $user->password = bcrypt($field['password']);
//        $user->save();
    }

    public function edit($fields)
    {
//        $this->fill($fields);
//        $this->password = bcrypt($fields['password']);
//        $this->save();
    }

    public function remove()
    {
        //$this->delete();
    }

    public function uploadAvatar($image)
    {
        if ($image == null) { return; }
//        Storage::delete('uploads/' . $this->image);
//        $filename = Str::random(60) . '.' . $image->extension();
//        $image->saveAs('uploads', $filename);
//        $this->image = $filename;
//        $this->save();
    }

    public function getAvatar()
    {
//        if ($this->image == null) { return '/img/no_img_user.jpg'; }
//        return '/uploads/' . $this->image;
    }
}
