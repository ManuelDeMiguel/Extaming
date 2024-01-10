@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Mensajes</h1>

        <div class="messages">
            <h2>Mis Conversaciones</h2>
            <ul>
                @foreach($conversations as $conversation)
                    @if($conversation->receiver->id == $authUser->id)
                        <li>
                            <a href="{{ route('direct-messages.show', ['conversation' => $conversation, 'user' => $conversation->user]) }}">
                                {{ $conversation->user->name }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('direct-messages.show', ['conversation' => $conversation, 'user' => $conversation->receiver]) }}">
                                {{ $conversation->receiver->name }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endsection
