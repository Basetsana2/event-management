@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-primary">All Events</h1>

    @auth
        @if(auth()->user()->role === 'organizer' || auth()->user()->role === 'admin')
            <a href="{{ route('events.create') }}" class="btn btn-success mb-4">+ Create Event</a>
        @endif
    @endauth

    @if($events->isEmpty())
        <div class="alert alert-info text-center">No events found.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($events as $event)
                <div class="col">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary">{{ $event->title }}</h5>
                            <p class="card-text">{{ Str::limit($event->description, 80) }}</p>
                            <p class="text-muted small mb-1">
                                📍 {{ $event->location }}<br>
                                📅 {{ \Carbon\Carbon::parse($event->date)->format('F j, Y g:i A') }}
                            </p>
                            <p class="text-muted small">👤 {{ $event->organizer->name }}</p>

                            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary btn-sm mt-auto">View Details</a>

                            @auth
                                @if(auth()->user()->role === 'attendee' && !$event->registrations->contains('user_id', auth()->id()))
                                    <form method="POST" action="{{ route('events.register', $event) }}" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm w-100">Register</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
