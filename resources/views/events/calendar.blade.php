@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <h1 class="mb-4 fw-bold text-center text-primary">Upcoming Events Calendar</h1>

            @if($events->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    No events scheduled yet.
                </div>
            @else
                <div class="table-responsive shadow rounded">
                    <table class="table table-hover align-middle bg-white">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Title</th>
                                <th scope="col">Location</th>
                                <th scope="col">Organizer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($event->date)->format('F j, Y - g:i A') }}</td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>{{ $event->organizer->name ?? 'Unknown' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
