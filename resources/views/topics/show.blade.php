@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $topic->title }}</h1>

    <p>
        <small class="text-muted">Автор: {{ $topic->user->name }}</small><br>
        <small class="text-muted">Категория: {{ $topic->category->name }}</small>
    </p>

    <p>{{ $topic->body }}</p>

    @can('update-topic', $topic)
        <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-primary">Редактировать</a>
    @endcan

    @can('delete-topic', $topic)
        <form action="{{ route('topics.destroy', $topic->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
        </form>
    @endcan

    <hr>

    <h3>Комментарии</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @include('comments._form')

    @foreach($topic->comments()->latest()->get() as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <p>{{ $comment->body }}</p>
                <p>
                    <small class="text-muted">Автор: {{ $comment->user->name }}</small>
                </p>

                @can('update-comment', $comment)
                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-primary">Редактировать</a>
                @endcan

                @can('delete-comment', $comment)
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                    </form>
                @endcan

                <!-- Лайки и дизлайки -->
                <div>
                <button class="like-button" data-comment-id="{{ $comment->id }}">Лайк (<span id="likes-count-{{ $comment->id }}">0</span>)</button>
                <button class="dislike-button" data-comment-id="{{ $comment->id }}">Дизлайк (<span id="dislikes-count-{{ $comment->id }}">0</span>)</button>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        console.log('JavaScript работает'); // Проверяем, выполняется ли код

        $(document).on('click', '.like-button', function(e) {
            e.preventDefault();
            console.log('Нажата кнопка лайка'); // Проверяем, срабатывает ли обработчик событий

            var commentId = $(this).data('comment-id');
            console.log('Comment ID: ' + commentId); // Проверяем, получаем ли мы ID комментария

            $.ajax({
                url: '/votes',
                type: 'POST',
                {
                    comment_id: commentId,
                    is_like: true,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#likes-count-' + commentId).text(data.likes);
                    $('#dislikes-count-' + commentId).text(data.dislikes);
                },
                error: function(error) {
                    console.error('Ошибка при голосовании:', error);
                }
            });
        });

        $(document).on('click', '.dislike-button', function(e) {
            e.preventDefault();
            var commentId = $(this).data('comment-id');
            $.ajax({
                url: '/votes', // Убедитесь, что URL правильный
                type: 'POST',
                {
                    comment_id: commentId,
                    is_like: false,
                    _token: '{{ csrf_token() }}' // Важно: добавьте токен CSRF
                },
                success: function(data) {
                    $('#likes-count-' + commentId).text(data.likes);
                    $('#dislikes-count-' + commentId).text(data.dislikes);
                },
                error: function(error) {
                    console.error('Ошибка при голосовании:', error);
                }
            });
        });
    });
</script>
@endsection