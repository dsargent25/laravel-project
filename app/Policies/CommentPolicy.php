<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(User $user, Chirp $chirp, Comment $comment): bool
    {
        return $this->update($user, $comment);
    }
}
