@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-6">{{ $userCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text display-6">{{ $eventCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Registrations</h5>
                    <p class="card-text display-6">{{ $registrationCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3 class="mb-3">Latest Events</h3>
        <ul class="list-group">
            @foreach($latestEvents as $event)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $event->title }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- User Management Table --}}
    @if(isset($users))
    <div class="bg-white shadow rounded p-4 mt-5">
        <h2 class="text-xl font-semibold mb-4">User Management</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-capitalize">{{ $user->role }}</td>
                        <td>
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="form-select form-select-sm me-2">
                                    <option value="attendee" {{ $user->role === 'attendee' ? 'selected' : '' }}>Attendee</option>
                                    <option value="organizer" {{ $user->role === 'organizer' ? 'selected' : '' }}>Organizer</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
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
