<template>
    <div class="container">
        <div class="card">
            <h1 class="card-header">Log in</h1>
            <div class="card-body">
                <div class="alert alert-danger" v-if="error">
                    <p>Error with credentials</p>
                </div>
                <form autocomplete="off" @submit.prevent="login" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" v-model="params.name" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" v-model="params.password" required>
                    </div>
                    <div class="form-group">
                        Don't have an account? <router-link :to="{ name: 'register' }">Register</router-link>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
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
                    name: null,
                    password: null
                },
                state: 'init'
            }
        },
        computed: {
            error: function() {
                return this.state === 'error';
            }
        },
        methods: {
            login: function() {
                this.$auth.login({
                    data: this.params,
                    success: function () {},
                    error: (resp) => {
                        this.state = 'error';
                    },
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                });
            },
        }
    }
</script>
