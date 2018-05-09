<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\WeatherData as WeatherDataResource;

class Location extends JsonResource
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            // 'lat' => $this->lat, // are these necessary?
            // 'lon' => $this->lon,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,

            'weatherData' => new WeatherDataResource($this->weatherData),
        ];
    }
}
