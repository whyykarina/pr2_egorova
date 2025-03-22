@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Форум</h1>

    <div class="mb-3">
        <a href="{{ route('topics.create') }}" class="btn btn-primary">Создать тему</a>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Категории</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <li><a href="{{ route('categories.topics', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @foreach($topics as $topic)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('topics.show', $topic->id) }}">{{ $topic->title }}</a></h5>
                        <p class="card-text">{{ Str::limit($topic->body, 200) }}</p>
                        <p class="card-text">
                            <small class="text-muted">Автор: {{ $topic->user->name }}</small><br>
                            <small class="text-muted">Категория: {{ $topic->category->name }}</small><br>
                            <small class="text-muted">Комментариев: {{ $topic->comments_count }}</small>
                        </p>
                        <a href="{{ route('topics.show', $topic->id) }}" class="btn btn-primary">Читать</a>
                    </div>
                </div>
            @endforeach

            {{ $topics->links() }}
        </div>
    </div>
</div>
@endsection