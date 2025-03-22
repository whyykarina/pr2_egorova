@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Профиль пользователя</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <div class="row">
        <div class="col-md-4">
            @if($profile->avatar)
                <img src="" alt="Аватар" class="img-thumbnail">
            @else
                <img src="" alt="Нет аватара" class="img-thumbnail">
            @endif
        </div>
        <div class="col-md-8">
            <h2>{{ $user->name }}</h2>
            <p>Email: {{ $user->email }}</p>
            <p>Описание: {{ $profile->bio }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Редактировать профиль</a>
        </div>
    </div>
</div>
@endsection