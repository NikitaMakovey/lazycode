<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'type_id', 'source_id', 'user_id', 'direct_id', 'vote'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'vote' => 'boolean'
    ];

    /**
     * Vote for direct user (for direct_user's rating).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to_user()
    {
        return $this->belongsTo('App\User', 'direct_id', 'id');
    }

    /**
     * Vote's user (sender).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from_user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
