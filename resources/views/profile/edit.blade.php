@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактировать профиль</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="bio">Информация о себе</label>
            <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $profile->bio) }}</textarea>
        </div>

        <div class="form-group">
            <label for="avatar">Аватар</label>
            <input type="file" class="form-control-file" id="avatar" name="avatar">
        </div>

        <div class="form-group">
            <label for="password">Новый пароль</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('profile.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection