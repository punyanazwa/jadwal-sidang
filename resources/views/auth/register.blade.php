@extends('layouts.app')

@section('content')
<form action="{{ route('register') }}" method="POST">
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
    <div class="field">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>
    </div>
    <button type="submit">DAFTAR</button>
    <div class="link">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </div>
</form>
@endsection