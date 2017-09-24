require('./bootstrap');

window.Vue = require('vue');

Vue.component('data-table', require('./components/DataTable.vue'));

const app = new Vue({
    el: '#app'
});
