<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {
        $user = auth()->user();

        // Verificar si el usuario ya dio like al post
        $existingLike = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();

        if ($existingLike) {
            // Si ya existe un like del usuario en el post, eliminarlo
            $existingLike->delete();
        } else {
            // Si no existe un like del usuario en el post, crearlo
            $like = new Like([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $like->save();
        }

        return redirect()->back();
    }
}
