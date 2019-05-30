<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'reply_to_user_id', 'parent_comment_id'];
    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
    public function comments()
    {
        return $this->hasMany(
            Comment::class,
            'parent_comment_id'
        );
    }
    public function parent() {
        return $this->belongsTo(
            Comment::class,
            'parent_comment_id'
        );
    }
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
