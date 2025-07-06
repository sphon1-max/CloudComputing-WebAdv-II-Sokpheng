<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class UsersController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function AllOrganizers()
    {
        $organizers = $this->apiService->getOrganizers();

        if ($organizers === null) {
            return back()->with('error', 'Failed to fetch organizers from API');
        }

        return view('Organizers', ['v_orga' => $organizers['data'] ?? $organizers]);
    }

    public function destroyOrga($id)
    {
        $result = $this->apiService->deleteOrganizer($id);

        if ($result === null) {
            return redirect('/organizer')->with('error', 'Failed to delete organizer');
        }

        return redirect('/organizer')->with('success', 'Organizer deleted successfully.');
    }

    public function AllUsers()
    {
        // For now, since we don't have a users endpoint, we'll show a message
        // You can add a simple users API endpoint to your main project later
        return view('users', [
            'v_user' => [],
            'message' => 'Users endpoint not yet implemented in main API. Please add /v1/admin/users endpoint to your main project.'
        ]);
    }

    public function destroyUser($id)
    {
        return redirect('/user')->with('error', 'Delete user functionality not yet implemented in main API.');
    }
}
