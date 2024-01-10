@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <!-- Espacio en blanco en la columna izquierda -->
            </div>
            <div class="col-md-8 col-lg-6 ">
                <h1 class="mb-4">{{ $user->name }}</h1>
                <div class="conversation">
                    <div class="messages-container bg-black bg-opacity-50 p-3 rounded">
                        @foreach ($messages as $message)
                            <div class="message mb-3 {{ $message->sender_id == Auth::user()->id ? 'text-end' : '' }}">
                                <div class="message-content p-3 border rounded">
                                    <div class="message-text bg-secondary bg-opacity-50"><a href="{{ route('other-profile', $message->sender_id) }}">{{$message->sender_id == Auth::user()->id ? "Yo" : $user->name }}</a></div>
                                    <div class="message-text">{{ $message->message }}</div>
                                    <div class="message-time text-light small">{{ $message->created_at->format('H:i A') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <form class="mt-3 message-form" action="{{ route('direct-messages.store', ['conversation' => $conversation, 'user' => $user, 'message' => $messages->count()]) }}" method="post">
                        @csrf
                        <div class="input-group">
                            <textarea class="form-control message-input no-resize bg-white bg-opacity-50" name="message" placeholder="Escribe tu mensaje..."></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-primary mt-3" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <!-- Espacio en blanco en la columna derecha -->
            </div>
        </div>
    </div>
@endsection
