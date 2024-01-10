@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Posts</h1>

        <div class="row">
            @auth
                <!-- Formulario para crear un nuevo post -->
                <div class="col-md-8 mb-4 ">
                    <form action="{{ route('posts.create') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control no-resize opacity-50" name="content" rows="4" placeholder="Escribe tu nuevo post"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publicar</button>
                    </form>
                </div>
            @endauth

            <div class="col-md-8">
                @foreach($posts as $post)
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
