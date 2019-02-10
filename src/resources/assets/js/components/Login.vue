<template>
    <v-container grid-list-md>
        <v-layout row wrap>
            <v-flex xs4 offset-xs4>
                <v-card class="elevation-12">

                    <v-toolbar dark color="grey lighten-1">
                        <v-toolbar-title>Login form</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <form @submit.prevent="authenticate">

                            <div class="form-group row" v-if="authError">
                                <p class="error">
                                    {{authError}}
                                </p>
                            </div>
                            <v-text-field
                                    prepend-icon="email"
                                    v-model="formLogin.email"
                                    v-validate="'required|email'"
                                    :error-messages="errors.collect('email')"
                                    label="Email address"
                                    data-vv-name="email"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="lock"
                                    v-validate="'required|max:30|min:6'"
                                    :error-messages="errors.collect('password')"
                                    :type="'password'"

                                    label="password"
                                    data-vv-name="password"
                                    required
                                    v-model="formLogin.password"
                            ></v-text-field>
                        </form>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn @click="submit">Login</v-btn>

                    </v-card-actions>

                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {login} from '../auth';
    export default {
        data(){
            return {
                formLogin: {
                    email: '',
                    password: ''
                },
                error: null
            }
        },
        methods:{
            authenticate(){
                this.$store.dispatch('login');
                login(this.$data.formLogin)
                    .then(res => {
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({path: '/dashboard'});
                    })
                    .catch(error => {
                        this.$store.commit("loginFailed", {error});
                    })
            },

            submit () {
                this.$validator.validateAll()
                    .then((okay) => (okay === true) ? this.authenticate() : console.log("error"))
                    .catch((errors) => console.log(errors));
            }

        },
        computed:{
            authError(){
                return this.$store.state.auth_error

            },
            registeredUser(){
                return this.$store.state.registeredUser
            }
        }
    }
</script>

<style scoped>
    .error{
        text-align: center;
        color: black;
    }
</style>