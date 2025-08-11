<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->with('events')->get();

        return view('admin.dashboard', compact('users'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::find($id);

        $event->start = $request->input('updateStart');
        $event->end = $request->input('updateEnd');
        $event->save();

        return redirect()->back();
    }

    public function destroyEvent($id)
    {
        $event = Event::find($id);
        $event->delete();

        return redirect()->back();
    }
}
