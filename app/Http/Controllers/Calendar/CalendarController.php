<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Event; // Ensure correct model import
use App\Models\Restaurants\restaurantslist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{

    public function index()
    {
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;
        if ($restaurantId) {
            $events = Event::where('restaurant_id', $restaurantId)->get();
        } else {
            $events = Event::all();
        }
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
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;

        if ($restaurantId) {
            $restaurants = restaurantslist::where('id', $restaurantId)->pluck('restaurantname', 'id');
        } else {
            $restaurants = restaurantslist::where('status', '1')->pluck('restaurantname', 'id');
        }
        return view('admin.calendar.addevent', ['restaurants' => $restaurants]);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'color' => 'nullable|string|max:7',
        ]);

        $event = new Event();
        $event->restaurant_id = $request->restaurants;
        $event->title = $request->title;
        $event->start_date = $request->start_date;
        $event->end_date = date('Y-m-d H:i:s', strtotime($request->end_date . ' +1 day'));
        $event->color = $request->color;
        $event->save();

        // Event::create($validated);
        return redirect()->route('admin.calendar.calendar')->with('success', 'Event added successfully.');
    }

    public function list()
    {
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;
        if ($restaurantId) {
            $events = Event::where('restaurant_id', $restaurantId)->get();
        } else {
            $events = Event::all();
        }
        // $events = Event::all();
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
        $event->title = $validated['title'];
        $event->start_date = $validated['start_date'];


        $event->end_date = date('Y-m-d H:i:s', strtotime($validated['end_date'] . ' +1 day'));
        $event->color = $validated['color'];
        $event->save();

        return redirect()->route('admin.calendar.calendar')->with('success', 'Event updated successfully.');
    }
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.calendar.list')->with('success', 'Event deleted successfully.');
    }

}

