@extends('layouts.app')

@section('content')
    <div class="profile container">
        <h1>Mi Perfil</h1>
        <p>Nombre: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>

        <h2>Mis Amigos</h2>
        @if ($user->receivedFriendRequests)
            @foreach ($user->receivedFriendRequests as $request)
                <div>
                    {{ $request->sender->name }} te ha enviado una solicitud de amistad.
                    <form action="{{ route('accept.friend.request', ['user' => $request->sender_id]) }}" method="POST">
                        @csrf
                        <button type="submit">Aceptar</button>
                    </form>
                    <form action="{{ route('reject.friend.request', ['user' => $request->sender_id]) }}" method="POST">
                        @csrf
                        <button type="submit">Rechazar</button>
                    </form>
                </div>
            @endforeach
        @else
            <p>No tienes solicitudes de amistad pendientes.</p>
        @endif
        <ul>
            @if ($user->friends)
                @foreach($user->friends as $friend)
                    <li>
                        <a href="{{ route('other-profile', $friend->id) }}">{{ $friend->name }}</a>
                        <form action="{{ route('remove.friend', $friend) }}" method="POST">
                            @csrf
                            <button type="submit">Eliminar amigo</button>
                        </form>
                    </li>
                @endforeach
            @endif
        </ul>

        <div class="container">
            <h2>Mis Posts</h2>
            <div class="col-md-8">
                @foreach($user->posts as $post)
                    <div class="card mb-3 bg-info bg-opacity-25">
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
