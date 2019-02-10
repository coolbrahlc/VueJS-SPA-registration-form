<template>
    <v-container grid-list-md>
        <v-layout row wrap>
            <v-flex xs6 offset-xs3>
                <v-card class="elevation-12">

                    <v-toolbar dark color="grey lighten-1">
                        <v-toolbar-title>Your personal data</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <form @submit.prevent="add">

                            <v-text-field
                                    prepend-icon="person"
                                    v-validate="'required|max:55'"
                                    :counter="55"
                                    :error-messages="errors.collect('name')"
                                    label="Name"
                                    data-vv-name="name"
                                    required
                                    v-model="title"
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="person"
                                    v-validate="'required|max:55'"
                                    :counter="55"
                                    :error-messages="errors.collect('lastname')"
                                    label="Last name"
                                    data-vv-name="lastname"
                                    required
                                    v-model="lastname"
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="email"
                                    v-model="email"
                                    v-validate="'required|email'"
                                    :error-messages="errors.collect('email')"
                                    label="E-mail"
                                    data-vv-name="email"
                                    required
                            ></v-text-field>
                            <v-text-field
                                    prepend-icon="person"
                                    :counter="10"
                                    :error-messages="errors.collect('subject')"
                                    label="Subject"
                                    data-vv-name="subject"
                                    v-model="subject"
                            ></v-text-field>
                            <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    :return-value.sync="date"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                            >
                                <v-text-field
                                        slot="activator"
                                        v-model="date"
                                        label="Picker in menu"
                                        prepend-icon="event"
                                        readonly
                                ></v-text-field>
                                <v-date-picker v-model="date" no-title scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                    <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                </v-date-picker>
                            </v-menu>
                            <v-text-field
                                    :counter="10"
                                    :error-messages="errors.collect('country')"
                                    label="Country"
                                    data-vv-name="country"
                                    v-model="country"
                            ></v-text-field>

                            <vue-tel-input v-model="phone"
                                           v-validate="'required'"
                                           @onInput="onInput">
                            </vue-tel-input>


                        </form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click="submit">Next</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>


<script>
    import 'vue-tel-input/dist/vue-tel-input.css';
    import { mapState } from 'vuex';
    import axios from 'axios';
    import notes from '../api';

    export default {
        $_veeValidate: {
            validator: 'new'
        },


        name: 'CreateNote',

        data() {
          return {
              title: '',
              lastname: '',
              birth: '',
              subject: '',
              country: '',
              phone: '',
              email: '',
              date: new Date().toISOString().substr(0, 10),
              menu: false,
              phone: '',
          }
        },

        mounted() {
        },

        computed: {
            ...mapState([
                'emails'
            ]),
        },

        methods: {
            add() {
                console.log(this.phone);
                let form = new FormData;
                form.append("title", this.title);
                form.append("email", this.email);
                axios.post(`${notes}`, form)
                    .then(response => {
                        localStorage.last_id = response.data['id'];
                        this.$store.commit('FETCH_ID', response.data['id']);
                        this.$router.push('/update');
                        flash('Note Created.', 'success');
                    })
                    .catch(error => {
                        console.log(error);
                        let errorz = error.response['data']['errors'];
                        let array_errors = new Array();
                        for (let key in errorz) {
                            array_errors.push(errorz[key].join());
                        }
                        flash(array_errors, 'danger');
                    });

            },

            submit () {
                this.$validator.validateAll()
                    .then((okay) => (okay === true) ? this.add() : console.log("error"))
                    .catch((errors) => console.log(errors));
            },

            onInput({ number, isValid, country }) {
                console.log(number, isValid, country);
            },
        }
    }
</script>