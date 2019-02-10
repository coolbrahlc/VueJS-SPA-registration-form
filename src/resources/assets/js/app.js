import Vue from 'vue';
import VueRouter from 'vue-router';
import NoteApp from './components/NoteApp.vue';
import routes from './routes';
import notesStore from './store/notesStore';
import VueTelInput from 'vue-tel-input';
import axios from 'axios';
import VeeValidate from 'vee-validate'
import auth from './auth';
//import './bootstrap';
//import storeData from ‘./store.js’;
//import MainApp from ‘./components/MainApp.vue’;

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader

Vue.use(Vuetify);
Vue.use(VueTelInput);

const router = new VueRouter({
    //history: true,
    //mode: 'history',
    routes,
});
Vue.router = router;
Vue.use(VueRouter);


window.events = new Vue();
window.flash = function(message, type = 'success') {
    window.events.$emit('flash', message, type);
};


new Vue({
    el: '#app',
    render: h => h(NoteApp),
    router,
    store: notesStore,
});