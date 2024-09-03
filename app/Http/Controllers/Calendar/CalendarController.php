<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Event; // Ensure correct model import
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date, 
                'end' => $event->end_date,    
                'color' => $event->color, 
            ];
        }
        return view('admin.calendar.calendar', [
            'events' => $formattedEvents,
        ]);
    }

    public function create()
    {
        return view('admin.calendar.addevent');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'color' => 'nullable|string|max:7',
        ]);

        Event::create($validated);
        return redirect()->route('admin.calendar.calendar')->with('success', 'Event added successfully.');
    }

    public function list()
    {
        $events = Event::all();
        return view('admin.calendar.displayeventstable', ['events' => $events]);
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.calendar.editevent', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'color' => 'nullable|string|max:7',
        ]);

        $event = Event::findOrFail($id);
        $event->update($validated);

        return redirect()->route('admin.calendar.calendar')->with('success', 'Event updated successfully.');
    }
}
