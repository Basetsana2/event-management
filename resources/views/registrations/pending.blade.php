@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">Pending Registrations</h2>

    @if($registrations->isEmpty())
        <div class="alert alert-info text-center">No pending registrations at the moment.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Event</th>
                        <th>Attendee</th>
                        <th>Email</th>
                        <th>Registered At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $registration)
                        <tr>
                            <td>{{ $registration->event->title }}</td>
                            <td>{{ $registration->user->name }}</td>
                            <td>{{ $registration->user->email }}</td>
                            <td>{{ $registration->created_at->format('F j, Y g:i A') }}</td>
                            <td class="text-center">
                                <form action="{{ route('registrations.update', $registration) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form action="{{ route('registrations.update', $registration) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="declined">
                                    <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
