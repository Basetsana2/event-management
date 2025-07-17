@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Login to your account</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection
