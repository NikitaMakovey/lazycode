<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'type_id', 'source_id', 'user_id', 'direct_id', 'vote'
    ];

    /**
     * Vote for direct user (for direct_user's rating).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to_user()
    {
        return $this->belongsTo(User::class, 'direct_id', 'id');
    }

    /**
     * Vote's user (sender).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from_user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
