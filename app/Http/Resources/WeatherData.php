<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherData extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'conditions'  => $this->conditions,
            'icon'        => $this->icon,
            'temp'        => $this->temp,
            'humidity'    => $this->humidity,
            'pressure'    => $this->pressure,
            'cloud_cover' => $this->cloud_cover,
            'wind_speed'  => $this->wind_speed,
            'wind_dir'    => $this->wind_dir,
        ];
    }
}
