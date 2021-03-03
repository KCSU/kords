import Vue from 'vue'
require('./bootstrap');


import App from './components/App.vue'

const app = new Vue({
    el: '#app',
    components: { App }
});
