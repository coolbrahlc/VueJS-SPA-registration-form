<template>

    <v-container grid-list-md>
        <v-layout row wrap>
            <v-flex xs6 offset-xs3>
                <v-card class="elevation-12">

                    <v-toolbar dark color="grey lighten-1">
                        <v-toolbar-title>Login form</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <form @submit.prevent="update(lastId)">
                            <label>Photo
                                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                            </label>
                            <v-text-field
                                    v-validate="'max:10'"
                                    :counter="10"
                                    :error-messages="errors.collect('position')"
                                    label="Position"
                                    data-vv-name="position"
                                    v-model="position"
                            ></v-text-field>
                            <v-text-field
                                    v-validate="'max:10'"
                                    :counter="10"
                                    :error-messages="errors.collect('company')"
                                    label="Company"
                                    data-vv-name="company"
                                    v-model="company"
                            ></v-text-field>
                            <v-textarea
                                    v-validate="'max:2048'"
                                    :counter="2048"
                                    :error-messages="errors.collect('about')"
                                    label="About"
                                    data-vv-name="about"
                                    auto-grow
                                    box
                                    name="input-7-1"
                                    value="About you"
                                    v-model="about"
                            ></v-textarea>
                            <div>{{ lastId }}</div>
                        </form>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn  @click="submit(lastId)">Next</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import { Form } from './Form'
    import { mapState } from 'vuex';

    export default {
        name: 'UpdateNote',
        $_veeValidate: {
            validator: 'new'
        },

        data() {
            return {
                position: '',
                about: '',
                company: '',
            }
        },

        mounted() {

        },

        computed: {
            ...mapState({
               lastId: 'lastId'
            }),
        },

        methods: {
            update(lastId) {
                let form = new FormData;
                form.append("position", this.position);
                form.append("company", this.company);
                form.append("about", this.about);
                form.append("photo", this.file);
                //form.append("is_favourite", false);
                console.log(this.form2);
                if (localStorage.last_id) {
                    this.$store.dispatch('edit2', {id:localStorage.last_id, data:form});
                } else {
                    this.$store.dispatch('edit2', {id:lastId, data:form});
                }
                this.$router.push('/list');
                flash('Note Successfully Edited.');
            },

            submit (lastId) {
                this.$validator.validateAll()
                    .then((okay) => (okay === true) ? this.update(lastId) : console.log("error"))
                    .catch((errors) => console.log(errors));
            },

            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            }

        }
    }
</script>