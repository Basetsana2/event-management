@extends('layouts.app')

@section('content')

@if(session('status'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
        {{ session('status') }}
    </div>
@endif

<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">My Event Registrations</h1>

    @if ($registrations->isEmpty())
        <p class="text-gray-600">You haven't registered for any events yet.</p>
    @endif

    @foreach ($registrations as $registration)
        <div class="bg-white shadow rounded p-4 mb-4">
            <h2 class="text-xl font-semibold">{{ $registration->event->title }}</h2>
            <p class="text-gray-700">{{ $registration->event->description }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($registration->event->date)->format('F j, Y g:i A') }}</p>
            <p><strong>Location:</strong> {{ $registration->event->location }}</p>
            <p><strong>Status:</strong> 
                <span class="px-2 py-1 rounded text-black
                    @if($registration->status === 'approved') bg-green-600
                    @elseif($registration->status === 'declined') bg-red-600
                    @else bg-yellow-500
                    @endif
                ">
                    {{ ucfirst($registration->status) }}
                </span>
            </p>
        </div>

        <form method="POST" action="{{ route('registrations.destroy', $registration) }}" class="mt-2">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure you want to cancel this registration?')" class="bg-red-500 text-dark px-3 py-1 rounded">
                Cancel Registration
            </button>
        </form>

    @endforeach
</div>
@endsection
