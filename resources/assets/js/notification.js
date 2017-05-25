import store from './store'
import { mapMutations } from 'vuex'
import { mapActions } from 'vuex'
import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

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
