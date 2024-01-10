<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\DirectMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectMessageController extends Controller
{
    /**
     * Muestra la conversación y mensajes directos con un usuario específico.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation, User $user)
    {
        $authUser = Auth::user();


        // Encuentra o crea una conversación entre los dos usuarios
        $conversation = Conversation::where(function($query) use ($authUser, $user) {
            $query->where('user_id', $authUser->id)
                ->orWhere('receiver_id', $authUser->id);
        })->where(function($query) use ($authUser, $user) {
            $query->where('user_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })->first();

        if (!$conversation) {
            // Si no existe la conversación, créala
            $conversation = Conversation::Create([
                'user_id' => $authUser->id,
                'receiver_id' => $user->id,
            ]);
        }

        // Obtiene todos los mensajes de la conversación
        $messages = $conversation->messages()->with('sender')->get();

        return view('messages.direct-messages.conversation', compact('authUser', 'user', 'messages', 'conversation'));
    }

    /**
     * Almacena un nuevo mensaje directo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Conversation $conversation, User $user)
    {
        $authUser = Auth::user();


        // Crea un nuevo mensaje
        $message = new DirectMessage([
            'sender_id' => $authUser->id,
            'message' => $request->input('message'),
            'conversation_id' => $conversation->id,
        ]);

        // Guarda el mensaje en la conversación
        $conversation->messages()->save($message);

        return redirect()->route('direct-messages.show', ['conversation' => $conversation, 'user' => $user]);
    }
}
