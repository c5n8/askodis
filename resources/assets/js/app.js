require('./bootstrap')

window.Vue = require('vue')

Vue.component('search-bar', require('./components/SearchBar.vue'));
Vue.component('notification-menu', require('./components/NotificationMenu.vue'));
Vue.component('notification-popup', require('./components/NotificationPopup.vue'));
Vue.component('account-menu', require('./components/AccountMenu.vue'));
Vue.component('question', require('./components/Question.vue'));

const app = new Vue({
  el: '#app',
})
