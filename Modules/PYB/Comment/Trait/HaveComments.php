<?php

namespace PYB\Comment\Trait;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use PYB\Comment\Models\Comment;

trait HaveComments
{
    use HasRelationships;

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function activeComments()
    {
        return $this->morphMany(Comment::class, 'commentable')
        ->where('status', Comment::STATUS_ACTIVE)
            ->with('comments')
            ->whereNull('comment_id');
}

}
