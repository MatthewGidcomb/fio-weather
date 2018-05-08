<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Location;

class LocationsController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response($user->locations);
    }

    public function show(String $id)
    {
        // find location in user collection to guard against a user accessing
        // other users' locations
        $user = User::find(Auth::user()->id);
        $location = $user->locations->find($id);
        return response($location);
    }

    public function delete(String $id)
    {
        // find location in user collection to guard against a user deleting
        // other users' locations
        $user = User::find(Auth::user()->id);
        $location = $user->locations->find($id);
        if ($location && $location->delete()) {
            return response(['status' => 'success']);
        } else {
            return response(['status' => 'error']);
        }
    }
}
