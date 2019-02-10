import UpdateNote from './components/UpdateNote.vue'
import CreateNote from './components/CreateNote.vue'

import List from './components/List.vue'
import FavouriteList from './components/FavouriteList.vue'

import Register from './components/Register'
import Login from './components/Login'



const routes = [
    { path: '/', component: List },
    { path: '/create', component: CreateNote },
    { path: '/update', component: UpdateNote },
    { path: '/list', component: List },
    { path: '/favourite-list', component: FavouriteList },
    { path: '*', redirect: '/list' },

    {   path: '/register',
        name: 'register',
        component: Register
    },

    {   path: '/login',
        name: 'login',
        component: Login,
    },
];

export default routes;