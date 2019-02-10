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
                        <form @submit.prevent="register">

                            <div class="form-group row" v-if="regError">
                                <p class="error">
                                    {{regError}}
                                </p>
                            </div>

                            <v-text-field
                                    prepend-icon="person"
                                    v-model="formRegister.name"
                                    v-validate="'required'"
                                    :error-messages="errors.collect('name')"
                                    label="Name"
                                    data-vv-name="name"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="email"
                                    v-model="formRegister.email"
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
                                    v-model="formRegister.password"
                            ></v-text-field>
                        </form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click="submit">Register</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {registerUser} from '../auth';
    export default {
        data(){
            return {
                formRegister: {
                    name: '',
                    email: '',
                    password: ''
                },
                error: null
            }
        },
        methods:{
            register(){
                registerUser(this.$data.formRegister)
                    .then(res => {
                        console.log(res);
                        this.$store.commit("registerSuccess", res);
                        this.$router.push({path: '/login'});
                    })
                    .catch(error => {
                        this.$store.commit("registerFailed", {error});
                    })
            },

            submit () {
                this.$validator.validateAll()
                    .then((okay) => (okay === true) ? this.register() : console.log("error"))
                    .catch((errors) => console.log(errors));
            },
        },
        computed:{
            regError(){
                return this.$store.state.reg_error
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
