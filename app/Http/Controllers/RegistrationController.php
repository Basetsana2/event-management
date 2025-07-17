<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;


class RegistrationController extends Controller
{

use AuthorizesRequests;


    public function destroy(Registration $registration)
    {
        // Allow only the user who owns the registration to delete it
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

    $registration->delete();

    return redirect()->route('registrations.mine')->with('status', 'Registration cancelled.');
}



    public function myRegistrations()
    {
        $registrations = auth()->user()->registrations()->with('event')->latest()->get();
        return view('registrations.mine', compact('registrations'));
    }


/*
    public function approve(Registration $registration)
    {
        $registration->update(['status' => 'approved']);
        return back()->with('success', 'Registration approved.');
    }

    public function decline(Registration $registration)
    {
        $registration->update(['status' => 'declined']);
        return back()->with('success', 'Registration declined.');
    }
*/



public function pending()
{
    

    $registrations = Registration::where('status', 'pending')
        ->whereHas('event', fn($query) => $query->where('user_id', auth()->id()))
        ->with('event', 'user')->get();

    return view('registrations.pending', compact('registrations'));
}

public function approve(Registration $registration)
{
   

    $registration->status = 'approved';
    $registration->save();

    return back()->with('success', 'Registration approved.');
}

public function decline(Registration $registration)
{
    $this->authorize('update', $registration);

    $registration->status = 'declined';
    $registration->save();

    return back()->with('success', 'Registration declined.');
}



    public function register(Event $event)
    {
        // Prevent duplicate registration
        if ($event->registrations()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You already registered for this event.');
        }

        Registration::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'You have registered for this event!');
    }

    public function update(Request $request, Registration $registration)
{
    $this->authorize('update', $registration); // Optional: if you're using policies

    $request->validate([
        'status' => ['required', Rule::in(['approved', 'declined'])],
    ]);

    $registration->status = $request->status;
    $registration->save();

    return redirect()->back()->with('success', 'Registration status updated.');
}

}


