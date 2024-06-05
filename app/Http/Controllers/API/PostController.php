<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = Post::all();
        $posts = Post::with('comments', 'user')->orderBy('created_at', 'DESC')->get();

        // On retourne les résultats en JSON
        return response()->json([
            'status' => true,
            'message' => 'Posts récupérés avec succès',
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, Post $post)
    {
        $post = Post::create([
            'content' => $request->content,
            'tags' => $request->tags,
            'user_id' => $request->user_id,
        ]);

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $post->update([
                'image' => $imageName
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Post créé avec succès !',
            'post' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // On retourne les résultats en JSON
        return response()->json([
            'status' => true,
            'message' => 'Post récupéré avec succès !',
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update([
            'content' => $request->content,
            'tags' => $request->tags,
            'user_id' => $request->user_id,
        ]);

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $post->update([
                'image' => $imageName
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Le commentaire a été modifié avec succès !',
            'post' => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post supprimé avec succès !',
            'post' => $post,
        ]);
    }
}
