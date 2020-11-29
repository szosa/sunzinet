<template>
    <div id="app">
        <div>
            <b-navbar toggleable="lg" type="dark" variant="success">
                <b-collapse id="nav-collapse" is-nav>
                    <b-navbar-nav>
                        <b-nav-item :to="{ name: 'login'}" v-if="!loggedIn">Login</b-nav-item>
                        <b-nav-item :to="{ name: 'register'}" v-if="!loggedIn">Rejestracja</b-nav-item>
                        <b-button @click="logout" v-if="loggedIn" type="button">Wyloguj</b-button>
                    </b-navbar-nav>
                </b-collapse>
            </b-navbar>
        </div>
        <router-view/>
    </div>
</template>

<script>

    export default {
        name: 'App',
        components: {},
        computed: {
            loggedIn() {
                return this.$store.state.auth.status.loggedIn;
            }
        },
        methods: {
            logout(event) {
                event.preventDefault();
                this.$store.dispatch('auth/logout').then(() => {
                        this.$router.push({name: 'login'});
                    }
                )
            }
        }
    }
</script>

<style>

</style>
