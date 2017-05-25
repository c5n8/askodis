import '../lib/semantic/dist/semantic.js'
import store from './store'
import { mapMutations } from 'vuex'
import { mapActions } from 'vuex'
import Echo from "laravel-echo"

window._      = require('lodash');
window.moment = require('moment')
window.axios  = require('axios')
window.Pusher = require('pusher-js');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

let userId = document.head.querySelector('meta[name="user-id"]')

if (userId) {
  window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '15a9d7c6cf426d9c4b86',
    cluster: 'ap1',
    encrypted: true
  });

  window
    .Echo
    .private('App.User.' + userId.content)
    .notification(notification => {
      store.commit('incrementUnreadNotificationsCount')

      if (store.state.user.notifications.length > 0) {
        store.dispatch('getNotification', notification.id)
      }
    });
}
