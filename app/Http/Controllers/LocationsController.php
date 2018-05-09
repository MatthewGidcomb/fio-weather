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
        $locations = $user->locations;

        // update each location's weather data
        // this pulls from a cache to save on API calls
        // TODO: this is the wrong place to do this update;
        // maybe move this to a cron job?
        foreach ($locations as $location) {
            $location->weatherData->updateFromAPI();
        }

        return LocationResource::collection($user->locations);
    }

    public function create(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validatedProps = $request->validate([
            'name' => 'required|string'
        ]);

        $location = Location::newWithCoords($validatedProps);
        $weatherData = WeatherData::createWithAPIData($location);
        $user->locations()->save($location);
        $location->weatherData()->save(WeatherData::newWithAPIData($location));

        if ($location->id && $location->weatherData) {
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
