<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="/">
                    FIO Weather
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li v-if="!$auth.check()">
                            <router-link class="nav-link" :to="{ name: 'login' }">Login</router-link>
                        </li>
                        <li v-if="!$auth.check()">
                            <router-link class="nav-link" :to="{ name: 'register' }">Register</router-link>
                        </li>
                        <li v-if="$auth.check()">
                            <a class="nav-link" href="#" @click.prevent="logout()">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <router-view></router-view>
        </main>
  </div>
</template>
<script>
    export default {
        methods: {
            logout: function() {
                // log out of the application and navigate to login page
                // (navigation is necessary to ensure logout doesn't leave the
                //  user's locations on the page)
                this.$auth.logout();
                this.$router.push('login');
            }
        }
    }
</script>
