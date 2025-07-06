<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class EventController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function Eventdash()
    {
        $events = $this->apiService->getEvents();
        // Extract the actual events data from the nested structure
        $eventsData = $events['data']['data'] ?? $events['data'] ?? [];

        // Mock data for dashboard stats since we don't have these endpoints yet
        return view('dashboard', [
            'v_evd' => $eventsData,
            'total_users' => 0, // Will need users API endpoint
            'total_organizers' => 0, // Will get from events data
            'totalCommission' => 0, // Will need payments API endpoint
        ]);
    }

    public function destroy($id)
    {
        $result = $this->apiService->deleteEvent($id);

        if ($result === null) {
            return redirect('/dashboard')->with('error', 'Failed to delete event');
        }

        return redirect('/dashboard')->with('success', 'Event deleted successfully.');
    }

    public function approve($id)
    {
        $result = $this->apiService->approveEvent($id);

        if ($result === null) {
            return redirect('/dashboard')->with('error', 'Failed to approve event');
        }

        return redirect('/dashboard')->with('success', 'Event approved successfully.');
    }

    public function reject($id)
    {
        $result = $this->apiService->rejectEvent($id);

        if ($result === null) {
            return redirect('/dashboard')->with('error', 'Failed to reject event');
        }

        return redirect('/dashboard')->with('success', 'Event rejected successfully.');
    }

    public function currentEvents()
    {
        $events = $this->apiService->getEvents();
        // Extract the actual events data from the nested structure
        $eventsData = $events['data']['data'] ?? $events['data'] ?? [];

        // Filter approved/published events (current active events)
        $currentEvents = array_filter($eventsData, function ($event) {
            return isset($event['status']) &&
                ($event['status'] === 'published' || $event['status'] === 'approved');
        });

        return view('currentevent', ['events' => $currentEvents]);
    }

    public function requestEvents()
    {
        $events = $this->apiService->getEvents();
        // Extract the actual events data from the nested structure
        $eventsData = $events['data']['data'] ?? $events['data'] ?? [];

        // Filter pending/draft events (events awaiting approval)
        $requestEvents = array_filter($eventsData, function ($event) {
            return isset($event['status']) &&
                ($event['status'] === 'pending' || $event['status'] === 'draft');
        });

        return view('requestevent', ['events' => $requestEvents]);
    }

    public function accept($id)
    {
        // This would need an update endpoint in your main project
        // For now, return with message
        return redirect()->back()->with('error', 'Accept event functionality needs to be implemented in main API.');
    }

    public function EventCate()
    {
        // Categories would need a separate endpoint
        return view('category', [
            'v_cate' => [],
            'message' => 'Categories endpoint not yet implemented in main API.'
        ]);
    }

    public function destroyCate($id)
    {
        return redirect('/category')->with('error', 'Delete category functionality not yet implemented in main API.');
    }

    public function EventCity()
    {
        // Cities would need a separate endpoint
        return view('city', [
            'v_city' => [],
            'message' => 'Cities endpoint not yet implemented in main API.'
        ]);
    }

    public function destroyCity($id)
    {
        return redirect('/city')->with('error', 'Delete city functionality not yet implemented in main API.');
    }

    public function show($id)
    {
        $event = $this->apiService->getEvent($id);

        if ($event === null) {
            return redirect('/dashboard')->with('error', 'Event not found');
        }

        return view('eventdetail', [
            'event' => $event['data'] ?? $event,
            'maxSeats' => 0 // Would need ticket data from API
        ]);
    }
}
