<template>
    <div class="container">
        <div class="card">
            <h1 class="card-header">Register</h1>
            <div class="card-body">
                <div class="alert alert-danger" v-if="error && !success">
                    <p>Correct validation errors.</p>
                </div>
                <div class="alert alert-success" v-if="success">
                    <p>Registration completed. You can now <router-link :to="{name:'login'}">sign in.</router-link></p>
                </div>
                <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
                    <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" v-model="params.name" required>
                        <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="params.password" required>
                        <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>                
            </div>
        </div>
    </div>
</template>
<script> 
    export default {
        data: function() {
            return {
                params: {
                    name: '',
                    password: '',
                },
                state: 'init',
                errors: { }
            };
        },
        computed: {
            success: function() {
                return this.state === 'success';
            },
            error: function() {
                return this.state === 'error';
            }
        },
        methods: {
            register: function() {
                this.$auth.register({
                    data: this.params, 
                    success: () => {
                        this.state = 'success';
                    },
                    error: (resp) => {
                        this.state = 'error';
                        this.errors = resp.response.data.errors;
                    },
                    redirect: null
                });                
            }
        }
    }
</script>
