<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{


public function home()
{
    $events = \App\Models\Event::orderBy('date')->take(6)->get();
    return view('home', compact('events'));
}


public function calendar()
{
    $events = Event::orderBy('date')->get();

    // Prepare data for FullCalendar
    $calendarData = $events->map(function ($event) {
        return [
            'title' => $event->title,
            'start' => $event->date,
            'url' => route('events.show', $event->id),
        ];
    });

    return view('events.calendar', [
        'events' => $events,
        'calendarData' => $calendarData,
    ]);
}



    public function myEvents()
    {
        $events = Event::where('user_id', auth()->id())->with('registrations')->latest()->get();
        return view('events.mine', compact('events'));
    }


   public function index()
    {
        $events = Event::with(['organizer', 'registrations'])->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $validated['user_id'] = Auth::id();
        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event created.');
    }

   public function show(Event $event)
    {
        $event->load('registrations.user');
        return view('events.show', compact('event'));
    }


    public function edit(Event $event)
{
    $this->authorize('update', $event); // Organizer must be the owner
    return view('events.edit', compact('event'));
}

public function update(Request $request, Event $event)
{
    $this->authorize('update', $event);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'date' => 'required|date',
    ]);

    $event->update($validated);

    return redirect()->route('events.index')->with('success', 'Event updated successfully.');
}




    


    public function destroy(Event $event)
{
    

    $event->delete();

    return redirect()->route('events.mine')->with('success', 'Event deleted successfully.');
}

}
