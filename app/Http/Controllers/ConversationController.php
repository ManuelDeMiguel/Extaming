<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Muestra las conversaciones del usuario autenticado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authUser = Auth::user();
        $conversations = Conversation::where('user_id', $authUser->id)
            ->orWhere('receiver_id', $authUser->id)
            ->with('receiver')
            ->get();

        return view('messages.direct-messages.index', compact('conversations', 'authUser'));
    }

    /**
     * Almacena una nueva conversación en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $authUser = Auth::user();

        // Verifica si ya existe una conversación entre los dos usuarios
        $existingConversation = Conversation::where(function ($query) use ($authUser, $user) {
            $query->where('user_id', $authUser->id)->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($authUser, $user) {
            $query->where('user_id', $user->id)->where('receiver_id', $authUser->id);
        })->first();

        if ($existingConversation) {
            return redirect()->route('direct-messages.show', ['conversation' => $existingConversation]);
        }

        // Crea una nueva conversación si no existe
        $conversation = Conversation::create([
            'user_id' => $authUser->id,
            'receiver_id' => $user->id,
        ]);

        // Puedes enviar un mensaje inicial si lo deseas
        $message = new Message([
            'sender_id' => $authUser->id,
            'receiver_id' => $user->id,
            'message' => $request->input('message'),
        ]);

        $conversation->messages()->save($message);

        return redirect()->route('direct-messages.show', ['conversation' => $conversation]);
    }
}
