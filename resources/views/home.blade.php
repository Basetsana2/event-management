@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Welcome to EventManager</h1>
        <p class="lead">Create, manage, and join exciting events with ease!</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">Get Started</a>
        @endguest
    </div>

    <h2 class="mb-4 text-secondary">Upcoming Events</h2>

    @if($events->isEmpty())
        <div class="alert alert-info text-center">No events available at the moment. Please check back later.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($events as $event)
                <div class="col">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary">{{ $event->title }}</h5>
                            <p class="card-text text-muted">
                                {{ \Illuminate\Support\Str::limit($event->description, 100) }}
                            </p>
                            <div class="mt-auto">
                                <p class="text-secondary small mb-2">
                                    📍 {{ $event->location }}<br>
                                    📅 {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}
                                </p>
                                <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary btn-sm w-100">
                                    View Event
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
