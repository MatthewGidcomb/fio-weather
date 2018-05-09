<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Geocoder\Laravel\Facades\Geocoder;

use App\User;
use App\Location;
use App\WeatherData;
use App\Http\Resources\Location as LocationResource;

class LocationsController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return LocationResource::collection($user->locations);
    }

    public function create(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validatedProps = $request->validate([
            'name' => 'required|string'
        ]);

        // TODO: can creation of weatherData be moved to an event?
        $location = $user->locations()->save(Location::newWithCoords($validatedProps));
        $location->weatherData()->save(WeatherData::createWithAPIData($location));

        if ($location->id) {
            return response([], 201);
        } else {
            return response(['status' => 'failed to save location'], 422);
        }
    }

    public function show(String $id)
    {
        // find location in user collection to guard against a user accessing
        // other users' locations
        $user = User::find(Auth::user()->id);
        $location = $user->locations->find($id);
        return new LocationResource($location);
    }

    public function delete(String $id)
    {
        // find location in user collection to guard against a user deleting
        // other users' locations
        $user = User::find(Auth::user()->id);
        $location = $user->locations->find($id);
        if ($location && $location->delete()) {
            return response([], 204);
        } else {
            return response(['status' => 'unable to delete'], 422);
        }
    }
}
