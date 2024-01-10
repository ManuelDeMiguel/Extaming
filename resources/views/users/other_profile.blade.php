@extends('layouts.app')

@section('content')
    <div class="profile container">
        <h1>Perfil de {{ $user->name }}</h1>
        <p>Nombre: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>
        @auth
            <h2>Acciones</h2>
            @if (auth()->user()->id != $user->id)
                @if (!auth()->user()->isFriendsWith($user) && !auth()->user()->hasSentFriendRequestTo($user))
                    <form action="{{ route('send.friend.request', $user) }}" method="POST">
                        @csrf
                        <button type="submit">Enviar solicitud de amistad</button>
                    </form>
                @elseif (auth()->user()->hasSentFriendRequestTo($user))
                    <form action="{{ route('cancel.friend.request', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Cancelar solicitud de amistad</button>
                    </form>
                @elseif (auth()->user()->isFriendsWith($user))
                    <a href="{{ route('direct-messages.show', ['conversation' => $conversation, 'user' => $user]) }}" class="btn btn-primary">Ver Conversación</a>
                @endif
            @endif
        @endauth

        <div class="container">
            <h2>Posts de {{ $user->name }}</h2>
            <div class="col-md-8">
                @foreach($user->posts as $post)
                    <div class="card mb-3 bg-info bg-opacity-50">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('other-profile', $post->user->id) }}">{{ $post->user->name }}</a></h5>
                            <p class="card-text text-white">{{ $post->content }}</p>
                            <form action="{{ route('posts.like', $post->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-link text-warning"><i class="far fa-thumbs-up"></i> {{ $post->likes->count() }}</button>
                            </form>
                            <a href="{{ route('comments.show', $post->id) }}" class="btn btn-primary">Ver Comentarios</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
