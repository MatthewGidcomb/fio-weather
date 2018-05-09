<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Gmopx\LaravelOWM\LaravelOWM;

class WeatherData extends Model
{
    protected $fillable = [
        'location_id', 'conditions', 'icon',
        'temp', 'humidity', 'pressure', 'cloud_cover',
        'wind_speed', 'wind_dir', 'wind_gust'
    ];

    public static function createFromOWMResponse(CurrentWeather $current)
    {
        $weatherData = new WeatherData();
        $weatherData->conditions = $current->weather->description;
        $weatherData->icon = $current->weather->icon;
        $weatherData->temp = $current->temperature->getValue();
        $weatherData->humidity = $current->humidity->getValue();
        $weatherData->pressure = $current->pressure->getValue();
        $weatherData->cloud_cover = $current->clouds->getValue();
        $weatherData->wind_speed = $current->wind->speed->getValue();
        // the value for wind direction is degrees from N; the unit
        // is e.g., N, NE
        // the unit is probably more useful to a casual weather consumer
        $weatherData->wind_dir = $current->wind->direction->getUnit();

        return $weatherData;
    }

    public static function createWithAPIData(Location $location)
    {
        // TODO: clean all this up; can this be a facade?
        $owm = new LaravelOWM();
        return WeatherData::createFromOWMResponse($owm->getCurrentWeather([
            'lat' => $location->lat, 'lon' => $location->lon
        ], 'en', 'imperial'));
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
