# FIO Weather

An experimental / proof-of-concept weather app, using [OpenWeatherMap.org](https://openweathermap.org/) and [Google Maps Geocoding](https://developers.google.com/maps/documentation/geocoding/start) APIs.

## Overview
- Laravel + VueJS single page app
- Uses JWT-Auth with Vue-auth for simple authentication
- Uses Google Maps Geocoding API to convert user-typed locations into latitude and longitude for more accurate OpenWeatherMap weather data
- User can enter a location in pretty much any format supported by the Geocoding API
  - City, State
  - ZIP code
  - Full street address
- Uses coordinates determined when a location is created when requesting weather data from OpenWeatherMap
- Weather data for a user's locations is refreshed for each page load and when the refresh button is clicked
- API layer caches weather data for 15 minutes to reduce load on the OpenWeatherMap API, in accordance with recommendation in documentation to avoid repeating a request more than once in 10 minutes.
- Stores users and locations in an SQLite database

## Setup
Developed using [Laravel Valet](https://laravel.com/docs/5.6/valet).
- Clone the repository
- `npm install`
- edit .env to add API keys for OpenWeatherMap and Google Maps
- `npm run dev` or `npm run prod` to compile JS and CSS assets
- access the site

## Use
- Register with a user name and password
- After a successful registration, log in with those credentials (no email confirmation step to keep things simple, so don't run this on a public-facing server)
- Enter a location for which you're interested in the weather and submit the form
- After the new location loads, click the location name to toggle more current weather information
- Click refresh to pull new data, with the caveat that the API does not update very often so the content is unlikely to change
- Click the X to the right of the location item to delete it

## OpenWeatherMap
I've wanted to

## Future enhancements
- Consider removing WeatherData model in favor of performing API request (through caching layer) for weather info
- Layout of location name and weather overview could be improved
- Include forecast data (separate API call)
- Editing locations (currently you would have to delete the location and create it again)
- Improve handling of OpenWeatherMap API calls on server -- The Geocoder API is much cleaner by comparison

## License
MIT
