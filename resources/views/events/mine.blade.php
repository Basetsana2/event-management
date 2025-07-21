@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-primary">My Events</h1>

    @if ($events->isEmpty())
        <div class="alert alert-info text-center">You have not created any events yet.</div>
    @endif

    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($events as $event)
            <div class="col">
                <div class="card shadow h-100 border-0">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($event->description, 100) }}</p>
                        <p class="text-muted small mb-1">📅 {{ \Carbon\Carbon::parse($event->date)->format('F j, Y g:i A') }}</p>
                        <p class="text-muted small mb-2">📍 {{ $event->location }}</p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-outline-primary btn-sm">View</a>
                            

                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="ms-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
