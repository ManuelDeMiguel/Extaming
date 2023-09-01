<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all(); // Obtener todos los posts
        return view('posts.index', compact('posts')); // Pasar $posts a la vista
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $user->posts()->create(['content' => $request->input('content')]);

        return redirect()->back()->with('success', 'Publicación creada exitosamente.');
    }

    public function like(Post $post)
    {
        $user = auth()->user();
        $user->likes()->create(['post_id' => $post->id]);

        return redirect()->back();
    }

    public function comment(Request $request, Post $post)
    {
        $user = auth()->user();
        $post->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
        ]);

        return redirect()->back();
    }
}
