<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cmfcmf\OpenWeatherMap\CurrentWeather;
use Gmopx\LaravelOWM\LaravelOWM;

class WeatherData extends Model
{
    protected $fillable = [
        'location_id'
    ];

    /**
     * create a new WeatherData model populated with current weather data for $location
     */
    public static function newWithAPIData(Location $location)
    {
        $weatherData = new WeatherData(['location_id' => $location->id]);
        $weatherData->setFieldsFromOWMResponse(WeatherData::getCurrentWeather($location));
        return $weatherData;
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function updateFromAPI()
    {
        $this->setFieldsFromOWMResponse(WeatherData::getCurrentWeather($this->location));
        $this->save();
    }

    /**
     * get the current weather for $location from OpenWeatherMap
     * TODO: this doesn't really belong here, probably needs to be a facade
     */
    private static function getCurrentWeather(Location $location)
    {
        $owm = new LaravelOWM();
        $params = ['lat' => $location->lat, 'lon' => $location->lon];
        $lang = config('laravel-own')['lang'];
        $units = 'imperial';
        $useCache = true;
        $cacheTime = 900; // 900 seconds == 15 minutes
        return $owm->getCurrentWeather($params, $lang, $units, $useCache, $cacheTime);

    }

    /**
     * update this WeatherData instance from a laravel-owm API response
     */
    private function setFieldsFromOWMResponse(CurrentWeather $current)
    {
        $this->conditions = $current->weather->description;
        $this->icon = $current->weather->icon;
        $this->temp = $current->temperature->getValue();
        $this->humidity = $current->humidity->getValue();
        $this->pressure = $current->pressure->getValue();
        $this->cloud_cover = $current->clouds->getValue();
        $this->wind_speed = $current->wind->speed->getValue();
        // the value for wind direction is degrees from N; the unit is e.g. N, NE
        // the unit is probably more useful to a casual weather consumer
        $this->wind_dir = $current->wind->direction->getUnit();

        return $this;
    }
}
