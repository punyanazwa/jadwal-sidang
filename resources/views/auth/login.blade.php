@extends('layouts.app')

@section('content')
<form action="{{ route('login') }}" method="POST">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="field">
        <label>Username</label>
        <input type="text" name="username" value="{{ old('username') }}" required autofocus>
    </div>
    <div class="field">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">LOGIN</button>
    <div class="link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
    </div>
</form>
@endsection