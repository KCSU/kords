import { createRouter, createWebHistory } from 'vue-router';

import Rooms from '~/views/Rooms.vue';

// TODO: proper route management
export default createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: Rooms,
            name: 'Rooms'
        }
    ]
});
