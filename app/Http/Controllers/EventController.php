<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Category;
use App\Models\City;
use App\Models\EventImage;
use App\Models\User;
use App\Models\Payment;
use App\Models\Userticket;

class EventController extends Controller
{
    public function Eventdash()
    {
        $v_evd = Events::with(['category', 'city'])->get();
        $total_users = User::where('role_id', 1)->count();
        $total_organizers = User::where('role_id', 2)->count();
        $payments = Payment::all();
        $totalPayments = $payments->sum('total');
        $totalCommission = $totalPayments * 0.10;

        // Calculate total commission (10% of all payments)

        return view('dashboard', [
            'v_evd' => $v_evd,
            'total_users' => $total_users,
            'total_organizers' => $total_organizers,
            'totalCommission' => $totalCommission,
        ]);
    }
    public function destroy($id)
    {
        $event = events::findOrFail($id);
        $event->delete();

        return redirect('/dashboard')->with('success', 'Event deleted successfully.');
    }
    public function currentEvents()
    {
        $currentEvents = Events::with(['category', 'city'])
            ->where('status', 'published')
            ->get();

        return view('currentevent', ['events' => $currentEvents]);
    }
    public function requestEvents()
    {
        $requestEvents = Events::with(['category', 'city'])
            ->where('status', 'draft')
            ->get();

        return view('requestevent', ['events' => $requestEvents]);
    }

    public function accept($id)
    {
        $event = Events::findOrFail($id);
        $event->status = 'published';
        $event->save();

        return redirect()->back()->with('success', 'Event status changed to accepted.');
    }

    public function EventCate()
    {
        $v_cate = Category::withCount('events')->get();
        return view('category', ['v_cate' => $v_cate]);
    }
    public function destroyCate($id)
    {
        $cate = Category::findOrFail($id);
        $cate->delete();

        return redirect('/category')->with('success', 'Category deleted successfully.');
    }

    public function EventCity()
    {
        $v_city = City::withCount('events')->get();
        return view('city', ['v_city' => $v_city]);
    }
    public function destroyCity($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect('/city')->with('success', 'City deleted successfully.');
    }

    public function show($id)
    {
        $event = Events::with([
            'category',
            'city',
            'tickets',
            'eventimage',
            'organizer' => function ($query) {
                $query->where('role_id', 2);
            }
        ])->findOrFail($id);

        $maxSeats = $event->tickets->sum('quantity');

        return view('eventdetail', compact('event', 'maxSeats'));
    }
}
