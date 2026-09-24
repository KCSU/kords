import axios from 'axios';

// TODO: Refactor as service
window.api = axios.create({
    baseURL: '/api'
});

window.api.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
