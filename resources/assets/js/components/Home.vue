<template>
    <div class="container">
        <div class="card">
            <h1 class="card-header">Locations</h1>
            <div class="card-body">
                <div v-if="loading">Loading...</div>
                <div v-if="!loading && error">Unable to load locations.</div>
                <ul class="list-group" v-else>
                    <li class="list-group-item" v-for="location in locations" :key="location.id">
                        {{ location.name }}
                        <button type="button" class="close float-right" aria-label="Close" @click="deleteLocation(location)">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </li>
                </ul>
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
                locations: []
            }
        },
        created: function() {
            this.fetchLocations();
        },
        watch: {
            '$route': 'fetchLocations'
        },
        methods: {
            fetchLocations: function() {
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
            deleteLocation: function(location) {
                this.axios.delete('locations/' + location.id)
                    .then((response) => {
                        this.fetchLocations();
                    })
                    .catch((response) => {
                        console.error('error deleting location');
                    });
            }
        }
    }
</script>
