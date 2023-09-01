@extends('layouts.app')

@section('content')
    <div class="profile">
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

        <h2>Mis Posts</h2>
        @foreach($user->posts as $post)
            <div class="post">
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->content }}</p>
            </div>
        @endforeach
    </div>
@endsection
