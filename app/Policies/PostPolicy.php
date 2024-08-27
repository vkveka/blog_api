<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    // public function before(User $user): bool
    // {
    //     // if ($user->role->role == "admin") {
    //     //     return true;
    //     // } else {
    //     //     return false;
    //     // }

    //     // autre syntaxe
    //     return $user->role->role == "admin";
    // }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        // return $user->id == $post->user_id;
        return $user->id == $post->user_id || $user->role->role == "admin";
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id == $post->user_id;
        // return $user->id == $post->user_id || $user->role->role == "admin";
    }
}
