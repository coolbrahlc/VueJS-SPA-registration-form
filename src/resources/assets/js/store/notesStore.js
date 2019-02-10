import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import notes from '../api';
import VeeValidate from 'vee-validate';
import { ValidationProvider } from 'vee-validate';
Vue.component('ValidationProvider', ValidationProvider);
Vue.use(VeeValidate);
Vue.use(Vuex);

import {getLoggedinUser} from '../auth';
const user = getLoggedinUser();


const notesStore = new Vuex.Store({
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        reg_error: null,
        registeredUser: null,

        notes: [],
        emails: [],
        lastId: '',
        favouriteNotes: []
    },

    getters: {
        isLoading(state){
            return state.loading;
        },
        isLoggedin(state){
            return state.isLoggedin;
        },
    },

    mutations: {

        login(state){
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload){
            state.auth_error = null;
            state.isLoggedin = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload){
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state){
            localStorage.removeItem("user");
            state.isLoggedin = false;
            state.currentUser = null;
        },
        registerSuccess(state, payload){
            state.reg_error = null;
            state.registeredUser = payload.user;
        },
        registerFailed(state, payload){
            state.reg_error = payload.error;
        },


        FETCH(state, notes) {
            state.notes = notes;
        },

        FETCH_ID(state, lastId) {
            state.lastId = lastId;
        },

        GETEMAILS(state, emails) {
            state.emails = emails;
        },

        FETCH_FAVOURITE(state, favouriteNotes) {
            state.favouriteNotes = favouriteNotes;
        }
    },
    actions: {
        fetch({ commit }) {
            return axios.get(notes)
                .then(response => commit('FETCH', response.data))
                .catch();
        },

        getEmails({ commit }) {
            return axios.get('/api/email_index')
                .then(response => commit('GETEMAILS', response.data))
                .catch();
        },

        deleteNote({}, id) {
            axios.delete(`${notes}/${id}`)
                .then(() => this.dispatch('fetch'))
                .catch();
        },

        edit({}, note) {
            axios.put(`${notes}/${note.id}`, {
                title: note.title
            })
                .then(() => this.dispatch('fetch'))
                .catch(error => {
                        console.log(error.response)
                    });
        },

        edit2({}, data) {
            console.log(data);
            axios.post(`${notes}/${data.id}/update`, data.data)
                .then(() => this.dispatch('fetch'))
                .catch(error => {
                    console.log(error.response)
                });
        },

        toggleFavourite({}, id) {
            axios.put(`${notes}/${id}/toggleFavourite`, {
                is_favourite: true
            })
              .then(() => this.dispatch('fetch'))
        },

        fetchFavourite({commit}) {
          return axios.get(`${notes}?type=favourite`)
            .then(response => commit('FETCH_FAVOURITE', response.data))
            .catch();
        },

        add({commit}, data) {
            console.log(data);
            commit('FETCH_ID', data);
            localStorage.last_id = data;
        },

        login(context){
            context.commit("login");
        }
    }
});

export default notesStore;

