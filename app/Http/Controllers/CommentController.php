<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function show(Post $post)
    {
        // Obtener todos los comentarios del post en específico
        $comments = $post->comments;

        return view('posts.comments', compact('post', 'comments'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);


        $comment = new Comment([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'content' => $request->input('content'),
        ]);

        $comment->save();

        return back()->with('success', 'Comentario agregado exitosamente.');
    }
}
