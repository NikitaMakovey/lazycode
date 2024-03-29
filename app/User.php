<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email',
        'password', 'about', 'image',
        'specialization', 'is_admin',
        'admin_verified_is'
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

    /**
     * User's posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    /**
     * Votes that send to this user (for user's rating).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function to_votes()
    {
        return $this->hasMany(Vote::class, 'direct_id', 'id');
    }

    /**
     * Votes that this user sends (vote transactions).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function from_votes()
    {
        return $this->hasMany(Vote::class, 'user_id', 'id');
    }

    /**
     * User's comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id', 'id');
    }
}
