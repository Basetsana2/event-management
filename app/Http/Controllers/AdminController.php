<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Registration;


class AdminController extends Controller
{



    public function dashboard()
{
    return view('admin.dashboard', [
        'userCount' => \App\Models\User::count(),
        'eventCount' => \App\Models\Event::count(),
        'registrationCount' => \App\Models\Registration::count(),
        'latestEvents' => \App\Models\Event::latest()->take(5)->get(),
    ]);
}







    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $users = User::all();
        $events = Event::with('organizer')->latest()->get();
        $registrations = Registration::with(['user', 'event'])->latest()->get();

        return view('admin.dashboard', compact('users', 'events', 'registrations'));
    }


    public function approveRegistration(Registration $registration)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $registration->status = 'approved';
    $registration->save();

    return back()->with('status', 'Registration approved.');
}

public function declineRegistration(Registration $registration)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $registration->status = 'declined';
    $registration->save();

    return back()->with('status', 'Registration declined.');
}



public function destroyEvent(Event $event)
{
    if (auth()->user()->role !== 'admin') abort(403);

    $event->delete();

    return back()->with('status', 'Event deleted.');
}

public function destroyUser(User $user)
{
    if (auth()->user()->role !== 'admin') abort(403);

    if ($user->id === auth()->id()) {
        return back()->with('error', 'You cannot delete your own account.');
    }

    $user->delete();

    return back()->with('status', 'User deleted.');
}


  public function roleRequests()
    {
        $users = User::where('role', 'attendee')
            ->where('requested_role', 'organizer')
            ->get();

        return view('admin.role-requests', compact('users'));
    }

    public function approve(User $user)
    {
        if ($user->role === 'attendee' && $user->requested_role === 'organizer') {
            $user->role = 'organizer';
            $user->requested_role = 'attendee'; // reset
            $user->save();

            return redirect()->route('admin.role.requests')->with('success', 'User promoted to Organizer.');
        }

        return redirect()->route('admin.role.requests')->with('error', 'Invalid role change request.');
    }


}
