@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать комментарий</h1>

        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="body">Комментарий</label>
                <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="3">{{ old('body', $comment->body) }}</textarea>
                @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('topics.show', $comment->topic_id) }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection