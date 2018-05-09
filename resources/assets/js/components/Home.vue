<template>
    <div class="container">
        <div class="card">
            <h1 class="card-header">Locations</h1>
            <div class="card-body">
                <div v-if="loading">Loading...</div>
                <div v-else-if="!loading && error">Unable to load locations.</div>
                <div v-else>
                    <div class="mb-4">
                        <button type="button" class="btn btn-small btn-primary" @click="fetchLocations()">Refresh</button>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="location in locations" :key="location.id">
                            <div class="location-row d-flex flex-row justify-content-between">
                                <div class="location-info">
                                    <a role="button" class="d-block d-sm-inline" aria-label="show more information" aria-expanded="false" :aria-controls="'#location-details-' + location.id" data-toggle="collapse" :data-target="'#location-details-' + location.id">
                                        <span aria-hidden="true" class="mr-2">&rtrif;</span>
                                        <strong class="location-name text-primary">{{ location.name }}</strong>
                                    </a>
                                    <span class="location-weather ml-2 d-block d-sm-inline" v-if="location.weatherData">
                                        <span class="weather-temp">
                                            {{ location.weatherData.temp }} &deg; F
                                        </span>
                                        <i class="weather-icon owi" :class="'owi-' + location.weatherData.icon"></i>
                                        <span class="weather-conditions">
                                            {{ location.weatherData.conditions }}
                                        </span>
                                    </span>
                                </div>
                                <div class="location-actions">
                                    <button type="button" class="close" aria-label="Delete" @click="deleteLocation(location)">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div :id="'location-details-' + location.id" class="location-details border-top pt-2 collapse" v-if="location.weatherData">
                                <div class="row">
                                    <div class="col-sm">
                                        <dl class="row">
                                            <dt class="col-7 col-md-8">Humidity</dt>
                                            <dd class="col-5 col-md-4 weather-humidity">{{ location.weatherData.humidity }} %</dd>
                                            <dt class="col-7 col-md-8">Pressure</dt>
                                            <dd class="col-5 col-md-4 weather-pressure">{{ location.weatherData.pressure }} mbr</dd>
                                        </dl>
                                    </div>
                                    <div class="col-sm">
                                        <dl class="row">
                                            <dt class="col-7 col-md-8">Cloud Cover</dt>
                                            <dd class="col-5 col-md-4 weather-cloud-cover">{{ location.weatherData.cloud_cover }} %</dd>
                                            <dt class="col-7 col-md-8">Wind</dt>
                                            <dd class="col-5 col-md-4 weather-wind">{{ location.weatherData.wind_dir }} {{ location.weatherData.wind_speed }} mph</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h2 class="h4">Add a location</h2>
                            <form autocomplete="off" @submit.prevent="createLocation" method="POST">
                                <div class="form-group" v-bind:class="{ 'has-error': errors && errors.name }">
                                    <label for="name">City, State or ZIP code</label>
                                    <input type="text" id="name" class="form-control" v-model="newLocation.name" required>
                                    <span class="help-block" v-if="errors && errors.name">{{ errors.name }}</span>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                loading: true,
                error: false,
                newLocation: {
                    name: ''
                },
                errors: {},
                locations: []
            }
        },
        created: function() {
            this.fetchLocations(true);
        },
        watch: {
            '$route': 'fetchLocations'
        },
        methods: {
            fetchLocations: function(showLoading) {
                if (showLoading)
                    this.loading = true;

                this.axios.get('locations')
                    .then((response) => {
                        this.locations = response.data;
                    })
                    .catch((response) => {
                        this.error = true;
                        console.error('error retrieving locations');
                    })
                    .finally((response) => {
                        this.loading = false;
                    });
            },
            createLocation: function() {
                this.axios.post('locations', this.newLocation)
                    .then(() => {
                        this.errors = {};
                        this.resetForm();
                        this.fetchLocations();
                    })
                    .catch((resp) => {
                        this.errors = resp.response.data.errors;
                    });
            },
            deleteLocation: function(location) {
                this.axios.delete('locations/' + location.id)
                    .then((response) => {
                        this.fetchLocations();
                    })
                    .catch((response) => {
                        console.error('error deleting location');
                    });
            },
            resetForm: function() {
                this.newLocation = {
                    name: ''
                };
            }
        }
    }
</script>
<style lang="scss">

    .location-row {

        a[data-toggle] {
            cursor: pointer;

            [aria-hidden] {
                font-size: 1.75em;
                line-height: 1;
            }
        }

        .weather-icon {
            font-size: 2em;
            vertical-align: bottom;
        }

        .weather-temp {
            font-size: 1.5em;
        }
    }

</style>
