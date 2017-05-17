require('./bootstrap')

window.Vue = require('vue')

Vue.component('question', require('./components/Question.vue'));

const app = new Vue({
    el: '#app'
})
