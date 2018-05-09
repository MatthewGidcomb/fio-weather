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
                        <location-list-item
                            v-for="location in locations"
                            :location="location"
                            :key="location.id"
                            @delete-location="deleteLocation($event)"
                        ></location-list-item>
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
    import LocationListItem from './locations/LocationListItem.vue';

    export default {
        components: {
            'location-list-item': LocationListItem
        },
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
