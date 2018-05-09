<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Geocoder\Laravel\Facades\Geocoder;

use App\User;
use App\Location;

class LocationsController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response($user->locations);
    }

    public function create(Request $request)
    {
        $validatedProps = $request->validate([
            'name' => 'required|string'
        ]);

        // determine latitude and longitude of location using Google Maps API
        // this allows users to enter either a city, state combination or a
        // ZIP code while leveraging coordinates for the OpenWeatherMap API,
        // which is more reliable than trying to pass it city, state or ZIP
        $geocodeRes = Geocoder::geocode($validatedProps['name'])->get()->first();
        if ($geocodeRes) {
            $coords = $geocodeRes->getCoordinates();
            $validatedProps['lat'] = $coords->getLatitude();
            $validatedProps['lon'] = $coords->getLongitude();

            // TODO: if a user provides a ZIP code, convert that to a city name
        }

        $user = User::find(Auth::user()->id);
        if ($user->locations()->create($validatedProps)) {
            return response(['status' => 'success']);
        } else {
            return response(['status' => 'error']);
        }
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
