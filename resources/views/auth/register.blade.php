@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Create an Account</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" name="password" required>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection
