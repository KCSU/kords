import Vue from 'vue'
import Router from 'vue-router'

import Rooms from '~/views/Rooms'
import Homepage from '~/views/Homepage'

Vue.use(Router);
// TODO: proper route management
let router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Rooms,
            name: 'Rooms'
        }
    ]
});

export default router;