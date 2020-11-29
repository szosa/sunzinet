<template>
    <b-row>
        <b-col md="6" offset-md="3">
            <b-alert variant="danger" show v-if="registrationError">Cos poszło nie tak, Spróbuj ponownie</b-alert>
            <b-alert variant="success" show v-if="registrationSuccess">Rejestracja zakończona sukcesem, na podany email
                wysłano link aktywacyjny, kliknij w niego aby zakończyć rejestracje
            </b-alert>
            <b-form @submit="onSubmit">
                <ValidationObserver v-slot="{ invalid }">

                    <b-form-group
                            id="input-group-email"
                            label="Adres email:"
                            label-for="input-email"
                    >
                        <ValidationProvider v-slot="{ errors }" rules="required|email">
                            <b-form-input
                                    id="input-email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    placeholder="Adres email"
                            ></b-form-input>
                            <b-form-invalid-feedback :state="errors.length === 0 "
                                                     v-for="(error, index) in errors"
                                                     :key="index">
                                {{error}}
                            </b-form-invalid-feedback>
                        </ValidationProvider>
                    </b-form-group>
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
                            <b-form-invalid-feedback :state="errors.length === 0 "
                                                     v-for="(error, index) in errors"
                                                     :key="index">
                                {{error}}
                            </b-form-invalid-feedback>
                        </ValidationProvider>
                    </b-form-group>
                    <b-form-group id="input-group-password" label="Hasło:" label-for="input-password">
                        <ValidationProvider v-slot="{ errors }"
                                            rules="required|min:6|passwordStrength|repeat:@repeatPassword">
                            <b-form-input
                                    id="input-password"
                                    v-model="form.password"
                                    required
                                    placeholder="Hasło"
                                    type="password"
                            ></b-form-input>
                            <b-form-invalid-feedback :state="errors.length === 0 "
                                                     v-for="(error, index) in errors"
                                                     :key="index">
                                {{error}}
                            </b-form-invalid-feedback>
                        </ValidationProvider>
                    </b-form-group>
                    <b-form-group id="input-group-password-repeat"
                                  label="Powtórz hasło:"
                                  label-for="input-password-repeat">
                        <ValidationProvider v-slot="{ errors }" rules="required" name="repeatPassword">
                            <b-form-input
                                    id="input-password-repeat"
                                    v-model="form.passwordRepeat"
                                    required
                                    placeholder="Powtórz hasło"
                                    type="password"
                            ></b-form-input>
                            <b-form-invalid-feedback :state="errors.length === 0 "
                                                     v-for="(error, index) in errors"
                                                     :key="index">
                                {{error}}
                            </b-form-invalid-feedback>
                        </ValidationProvider>
                    </b-form-group>
                    <b-button type="submit" :disabled="invalid" variant="success">
                        <b-spinner small type="grow" v-if="registrationInProgress"></b-spinner>
                        Zarejestruj się
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
    import {required, email, min} from 'vee-validate/dist/rules';

    extend('required', {
        ...required,
        message: 'Te pole jest obowiązkowe'
    });
    extend('email', {
        ...email,
        message: 'Podaj poprawny adres email'
    });
    extend('min', {
        ...min,
        message: 'Hasło musi zawierać conajmniej 6 znaków'
    });
    extend('repeat', {
        params: ['target'],
        validate(value, {target}) {
            return value === target;
        },
        message: 'Podane hasła nie są takie same'
    });
    extend('passwordStrength', value => {
        let score = 0;
        let RegexLowerCase = new RegExp("^(?=.*[a-z])");
        let RegexUpperCase = new RegExp("^(?=.*[A-Z])");
        let RegexNumber = new RegExp("^(?=.*[0-9])");
        let RegexSpecialChar = new RegExp("^(?=.*[!@#$%^&*])");
        RegexLowerCase.test(value) ? score++ : false;
        RegexUpperCase.test(value) ? score++ : false;
        RegexNumber.test(value) ? score++ : false;
        RegexSpecialChar.test(value) ? score++ : false;
        if (score >= 2) {
            return true;
        }
        return "Hasło musi spełniać conajmniej 2 wymagania: mała litera, duża litera, cyfra, znak specjalny"
    });

    export default {
        name: "Register",
        components: {
            ValidationObserver
        },
        data() {
            return {
                form: {
                    username: '',
                    email: '',
                    password: '',
                    passwordRepeat: ''
                },
                registrationSuccess: false,
                registrationError: false,
                registrationInProgress: false
            }
        },
        computed: {
            loggedIn() {
                return this.$store.state.auth.status.loggedIn;
            }
        },
        mounted() {
            if (this.loggedIn) {
                this.$router.push('/dashboard');
            }
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                this.registrationSuccess = false;
                this.registrationInProgress = true;
                this.registrationError = false;
                let user = new User(this.form.password, this.form.username, this.form.email);
                this.$store.dispatch('auth/register', user).then(() => {
                        this.registrationSuccess = true;
                        this.registrationInProgress = false;
                    }
                ).catch(() => {
                    this.registrationError = true;
                    this.registrationInProgress = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>