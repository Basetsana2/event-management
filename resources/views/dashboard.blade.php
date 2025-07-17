@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Dashboard</h1>

    @if(auth()->user()->role === 'admin')
        <p>Welcome, Admin. You can manage users, events, and registrations from the admin panel.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Panel</a>

    @elseif(auth()->user()->role === 'organizer')
        <p>Welcome, Organizer. Manage your events or create a new one.</p>
        <a href="{{ route('events.create') }}" class="btn btn-success">Create Event</a>
        <a href="{{ route('events.mine') }}" class="btn btn-outline-primary ms-2">My Events</a>

    @elseif(auth()->user()->role === 'attendee')
        <p>Welcome! You can view events or see those you’ve registered for.</p>
        <a href="{{ route('events.index') }}" class="btn btn-outline-primary">Browse Events</a>
        <a href="{{ route('registrations.mine') }}" class="btn btn-outline-secondary ms-2">My Registrations</a>
    @endif
</div>
@endsection