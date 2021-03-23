import Vue from 'vue'
import Router from 'vue-router'

import Rooms from '~/views/Rooms'
import Homepage from '~/views/Homepage'

Vue.use(Router);

let router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Homepage,
            name: 'Homepage'
        },
        {
            path: '/rooms',
            name: 'Rooms',
            component: Rooms
        }
    ]
});

export default router;