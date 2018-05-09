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
        return WeatherData::createFromOWMResponse(WeatherData::getCurrentWeather($location));
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    private static function getCurrentWeather(Location $location)
    {
        // TODO: clean all this up; can this be a facade?
        $owm = new LaravelOWM();
        $params = ['lat' => $location->lat, 'lon' => $location->lon];
        $lang = config('laravel-own')['lang'];
        $units = 'imperial';
        $cache = true;
        $cacheTime = 900; // 900 seconds == 15 minutes
        return $owm->getCurrentWeather($params, $lang, $units, $cache, $cacheTime);

    }
}
