<template>
    <b-row>
        <b-col md="6" offset-md="3">
            <b-alert variant="danger" show v-if="loginError">Nieprawidłowe dane logowania</b-alert>
            <b-form @submit="onSubmit">
                <ValidationObserver v-slot="{ invalid }">
                    <b-form-group
                            id="input-group-nick"
                            label="Nick:"
                            label-for="input-email"
                    >
                        <ValidationProvider v-slot="{ errors }" rules="required">
                            <b-form-input
                                    id="input-nick"
                                    v-model="form.username"
                                    type="text"
                                    required
                                    placeholder="Nick"
                            ></b-form-input>
                            <b-form-invalid-feedback :state="errors.length === 0 " v-for="(error, index) in errors"
                                                     :key="index">
                                {{error}}
                            </b-form-invalid-feedback>
                        </ValidationProvider>
                    </b-form-group>
                    <b-form-group id="input-group-password" label="Hasło:" label-for="input-password">
                        <ValidationProvider v-slot="{ errors }"
                                            rules="required">
                            <b-form-input
                                    id="input-password"
                                    v-model="form.password"
                                    required
                                    placeholder="Hasło"
                                    type="password"
                            ></b-form-input>
                            <b-form-invalid-feedback :state="errors.length === 0 " v-for="(error, index) in errors"
                                                     :key="index">
                                {{error}}
                            </b-form-invalid-feedback>
                        </ValidationProvider>
                    </b-form-group>

                    <b-button type="submit" :disabled="invalid" variant="success">
                        <b-spinner small type="grow" v-if="loginInProgress"></b-spinner>
                        Zaloguj się
                    </b-button>
                </ValidationObserver>
            </b-form>
        </b-col>
    </b-row>
</template>

<script>
    import User from '../models/User';
    import {extend} from 'vee-validate';
    import {ValidationObserver} from 'vee-validate';
    import {required} from 'vee-validate/dist/rules';

    extend('required', {
        ...required,
        message: 'Te pole jest obowiązkowe'
    });
    export default {
        name: "Login",
        components: {
            ValidationObserver
        },
        data() {
            return {
                form: {
                    username: '',
                    password: ''
                },
                loginInProgress: false,
                loginError: false
            }
        },
        computed: {
            loggedIn() {
                return this.$store.state.auth.status.loggedIn;
            }
        },
        created() {
            if (this.loggedIn) {
                this.$router.push('/dashboard');
            }
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                this.loginInProgress = true;
                let user = new User(this.form.password, this.form.username);
                this.$store.dispatch('auth/login', user).then(
                    () => {
                        this.$router.push({name: 'dashboard'});
                    }).catch(() => {
                    this.loginInProgress = false;
                    this.loginError = true;
                })
            }
        }
    }
</script>

<style scoped>

</style>