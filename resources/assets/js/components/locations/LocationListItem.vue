<template>
    <li class="list-group-item">
        <div class="location-row d-flex flex-row justify-content-between">
            <div class="location-info">
                <a
                    role="button"
                    aria-label="show more information"
                    aria-expanded="false"
                    :aria-controls="'#location-details-' + location.id"
                    data-toggle="collapse"
                    :data-target="'#location-details-' + location.id"
                    class="d-block d-sm-inline"
                >
                    <span aria-hidden="true" class="toggle-indicator mr-2"></span>
                    <strong class="location-name h4 text-primary">{{ location.name }}</strong>
                </a>
                <span class="location-weather ml-2 d-block d-sm-inline" v-if="location.weatherData">
                    <span class="weather-temp h3 mr-2">
                        {{ location.weatherData.temp }} &deg; F
                    </span>
                    <i class="weather-icon text-secondary align-top mr-2 owi" :class="'owi-' + location.weatherData.icon"></i>
                    <span class="weather-conditions">
                        {{ location.weatherData.conditions }}
                    </span>
                </span>
            </div>
            <div class="location-actions">
                <button
                    type="button"
                    aria-label="Delete"
                    class="close"
                    @click="$emit('delete-location', location)"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div
            :id="'location-details-' + location.id"
            class="location-details border-top mt-2 pt-2 collapse"
            v-if="location.weatherData"
        >
            <div class="row">
                <div class="col-sm">
                    <dl class="row">
                        <dt class="col-7 col-md-8">Humidity</dt>
                        <dd class="col-5 col-md-4 weather-humidity">
                            {{ location.weatherData.humidity }} %
                        </dd>
                        <dt class="col-7 col-md-8">Pressure</dt>
                        <dd class="col-5 col-md-4 weather-pressure">
                            {{ location.weatherData.pressure }} mbr
                        </dd>
                    </dl>
                </div>
                <div class="col-sm">
                    <dl class="row">
                        <dt class="col-7 col-md-8">Cloud Cover</dt>
                        <dd class="col-5 col-md-4 weather-cloud-cover">
                            {{ location.weatherData.cloud_cover }} %
                        </dd>
                        <dt class="col-7 col-md-8">Wind</dt>
                        <dd class="col-5 col-md-4 weather-wind">
                            {{ location.weatherData.wind_dir }} {{ location.weatherData.wind_speed }} mph
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </li>
</template>

<script>

    export default {
        props: ['location'],
    }
</script>
<style lang="scss">

    .location-row {

        a[data-toggle] {
            cursor: pointer;

            .toggle-indicator {
                font-size: 1.75em;
                line-height: 1;

                &:before {
                    content: '\25B8';
                }
            }

            &[aria-expanded="true"] .toggle-indicator:before {
                content: '\25BE';
            }
        }

        .weather-icon {
            font-size: 1.8rem;
        }
    }

</style>
