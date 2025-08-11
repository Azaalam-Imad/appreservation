<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $events = $events->map(function ($event) {
            $name = User::find($event->user_id);
            return [
                "owner" => $event->user_id,
                "start" => $event->start,
                "end" => $event->end,
                "id"=>$event->id,
                "backgroundColor" =>  'red',
                "title" => $name->name,
            ];
        });
        return response()->json([
            "events" => $events
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "start" => "required",
            "TypeSeance" => "required",
            "Typepayment" => "required",
            "end" => "required"
        ]);


        Event::create([
            "start" => $request->start,
            "end" => $request->end,
            "TypeSeance" => $request->TypeSeance,
            "Typepayment" => $request->Typepayment,
            "user_id" => Auth::user()->id

        ]);

        return redirect('/payment');

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function mySessions()
{
    $user = Auth::user();

    $events = Event::where('user_id', $user->id)->get();

    $unpaidEvents = $events->where('paid', false);
    $prixcardio = $unpaidEvents->where('TypeSeance', 'cardio')->count() * 5000;
    $prixmusculation = $unpaidEvents->where('TypeSeance', 'musculation')->count() * 6000;
    $prixyoga = $unpaidEvents->where('TypeSeance', 'yoga')->count() * 4000;
    $prixcrossfit = $unpaidEvents->where('TypeSeance', 'crossfit')->count() * 7000;
    $totalPrice = $prixcardio + $prixmusculation + $prixyoga + $prixcrossfit;

    return view('events', compact('events', 'totalPrice'));
}

public function updateSubscription(Request $request)
{
    $request->validate([
        'subscriptionType' => 'required|in:one_time,subscription',
    ]);

    $user = Auth::user();

    Event::where('user_id', $user->id)->update(['Typepayment' => $request->subscriptionType]);

    return redirect()->back();
}

public function destroy($id)
{
    $event = Event::find($id);
    $event->delete();

    return redirect()->back();
}

public function update(Request $request, $id)
{
    $request->validate([
        'start' => 'required|date',
        'end' => 'required|date|after:start',
    ]);

    $event = Event::find($id);
    $event->update([
        'start' => $request->start,
        'end' => $request->end,
    ]);

    return redirect()->back();
}}