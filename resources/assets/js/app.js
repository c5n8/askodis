require('./bootstrap')

window.Vue = require('vue')

Vue.component('question', require('./components/Question.vue'));
Vue.component('search-bar', require('./components/SearchBar.vue'));

const app = new Vue({
    el: '#app',
    mounted() {
      $('.ui .dropdown').dropdown()
    }
})
