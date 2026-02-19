<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function countOrganizers()
    {
        $count = User::where('role_id', 2)->count();
        return response()->json(['organizer_count' => $count]);
    }

    // Count normal users (role_id = 1)
    public function countRegularUsers()
    {
        $count = User::where('role_id', 1)->count();
        return response()->json(['user_count' => $count]);
    }

    public function AllOrganizers()
    {
        $v_orga = User::where('role_id', 2)->get();
        return view('Organizers', ['v_orga' => $v_orga]);
    }

    public function destroyOrga($id)
    {
        $orga = User::findOrFail($id);
        $orga->delete();

        return redirect('/organizer')->with('success', 'Organizer deleted successfully.');
    }

    public function AllUsers()
    {
        $v_user = User::where('role_id', 1)->get();
        return view('users', ['v_user' => $v_user]);
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('success', 'User deleted successfully.');
    }
}
