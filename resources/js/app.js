import Vue from 'vue'
import router from '~/router'
import TextareaAutosize from 'vue-textarea-autosize'

Vue.use(TextareaAutosize);

require('./bootstrap');

import App from '~/App'

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    template: "<app/>"
});
