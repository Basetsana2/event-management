@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-primary mb-3">{{ $event->title }}</h1>

    <div class="mb-4">
        <p><strong>Description:</strong> {{ $event->description }}</p>
        <p><strong>Location:</strong> {{ $event->location }}</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('F j, Y g:i A') }}</p>
        <p><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
    </div>

    @auth
        @if(auth()->user()->role === 'attendee' && !$event->registrations->contains('user_id', auth()->id()))
            <form method="POST" action="{{ route('events.register', $event) }}">
                @csrf
                <button type="submit" class="btn btn-success">Register</button>
            </form>
        @endif
    @endauth

    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary mt-3">← Back to Events</a>
</div>
@endsection
