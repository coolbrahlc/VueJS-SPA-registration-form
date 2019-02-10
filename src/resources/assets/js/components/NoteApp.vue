<template>
    <v-app>
        <v-toolbar app>
            <v-toolbar-title>Form</v-toolbar-title>
            <v-btn flat to="/create">Create</v-btn>
            <v-btn flat to="/list">List</v-btn>
            <v-btn flat to="/favourite-list">Hidden list</v-btn>
            <v-spacer></v-spacer>
            <v-conatiner v-if="!currentUser">
                <v-btn flat to="/login">Login</v-btn>
                <v-btn flat to="/register">Register</v-btn>
            </v-conatiner>
            <v-btn v-if="currentUser" icon href="#!" @click.prevent="logout">
                <v-icon>exit_to_app</v-icon>
            </v-btn>
        </v-toolbar>


        <v-content>
                <flash></flash>
                <router-view></router-view>
                <div class="alert alert-message messageBody"
                     id="messageBody"
                     style="visibility: hidden;"
                ></div>
        </v-content>
    </v-app>
</template>

<script>
    import axios from 'axios';
    import { mapState } from 'vuex';
    import Flash from './Flash.vue'

    export default {
        name: 'NoteApp',
        components: {
            flash: Flash
        },

        methods:{
            logout(){
                this.$store.commit('logout');
                this.$router.push('/login');
            }
        },

        computed:{
            currentUser(){
                return this.$store.state.currentUser
            }
        }
    }
</script>