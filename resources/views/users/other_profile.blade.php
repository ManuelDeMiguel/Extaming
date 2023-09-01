@extends('layouts.app')

@section('content')
    <div class="profile">
        <h1>Perfil de {{ $user->name }}</h1>
        <p>Nombre: {{ $user->name }}</p>
        <p>Email: {{ $user->email }}</p>

        <h2>Acciones</h2>
        @if (auth()->user()->id !== $user->id)
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
            @endif
        @endif

        <h2>Posts de {{ $user->name }}</h2>
        @foreach($user->posts as $post)
            <div class="post">
                <h3>{{ $post->title }}</h3>
                <p>{{ $post->content }}</p>
            </div>
        @endforeach
    </div>
@endsection
