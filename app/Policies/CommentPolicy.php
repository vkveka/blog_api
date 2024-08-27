<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    // public function before(User $user): bool
    // {
    //     // autre syntaxe
    //     return $user->role->role == "admin";
    // }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id == $comment->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id == $comment->post->user_id || $user->role->role == "admin" || $user->id == $comment->user_id;
    }
}
