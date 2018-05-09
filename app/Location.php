<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Geocoder\Laravel\Facades\Geocoder;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'lat', 'lon'
    ];

    /**
     *
     */
    public static function newWithCoords($props)
    {
        $location = new Location($props);

        // determine latitude and longitude of location using Google Maps API
        // this allows users to enter either a city, state combination or a
        // ZIP code while leveraging coordinates for the OpenWeatherMap API,
        // which is more reliable than trying to pass it city, state or ZIP
        $geocodeRes = Geocoder::geocode($location->name)->get()->first();
        if ($geocodeRes) {
            $location->lat = $geocodeRes->getCoordinates()->getLatitude();
            $location->lon = $geocodeRes->getCoordinates()->getLongitude();

            // TODO: if a user provides a ZIP code, convert that to a city name
        }

        // TODO: create WeatherData
        return $location;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weatherData()
    {
        return $this->hasOne(WeatherData::class);
    }
}
