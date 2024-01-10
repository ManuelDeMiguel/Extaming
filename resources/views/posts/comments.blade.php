@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Comentarios en el Post</h1>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card bg-info bg-opacity-25">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('other-profile', $post->user->id) }}">{{ $post->user->name }}</a></h5>
                        <p class="card-text text-white">{{ $post->content }}</p>
                        <form action="{{ route('posts.like', $post->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-link text-warning"><i class="far fa-thumbs-up"></i> {{ $post->likes->count() }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card bg-white bg-opacity-25 text-white">
                    <div class="card-body">
                        <h2 class="card-title">Comentarios</h2>
                        @foreach($comments as $comment)
                            <div class="comment mb-3">
                                <h6 class="card-subtitle mb-2 text-muted"><a href="{{ route('other-profile', $comment->user->id) }}">{{ $comment->user->name }}</a></h6>
                                <p class="card-text">{{ $comment->content }}</p>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card bg-info bg-opacity-25">
                    <div class="card-body">
                        <h2 class="card-title text-white">Añadir Comentario</h2>
                        <form action="{{ route('comments.store', ['post' => $post->id]) }}" method="POST">
                            @csrf
                            <textarea class="form-control no-resize bg-white bg-opacity-50" name="content" rows="4" placeholder="Escribe tu comentario"></textarea>
                            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
