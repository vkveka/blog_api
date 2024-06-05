<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('user')->get();

        // On retourne les résultats en JSON
        return response()->json([
            'status' => true,
            'message' => 'Commentaires récupérés avec succès',
            'comments' => $comments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Comment $comment)
    {
        $comment = Comment::create([
            'content' => $request->content,
            'tags' => $request->tags,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ]);

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $comment->update([
                'image' => $imageName
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Commentaire créé avec succès !',
            'comment' => $comment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        // On retourne les résultats en JSON
        return response()->json([
            'status' => true,
            'message' => 'Commentaire récupéré avec succès !',
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update([
            'content' => $request->content,
            'tags' => $request->tags,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ]);

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $comment->update([
                'image' => $imageName
            ]);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Le commentaire a été modifié avec succès !',
            'comment' => $comment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Commentaire supprimé avec succès !',
            'comment' => $comment,
        ]);
    }
}
