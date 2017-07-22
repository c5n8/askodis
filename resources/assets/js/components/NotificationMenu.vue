<template lang='jade'>
a#notificationMenu.item
  i.bell.outline.icon
  span.text {{ $t("Notifications") }}
  .ui.tiny.top.right.attached.red.label(v-show='user.unreadNotificationsCount > 0')
    | {{ user.unreadNotificationsCount }}
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import store from 'store'
import socket from 'lib/socket'

export default {
  store,
  props: ['count'],
  computed: {
    ...mapState([
      'user'
    ])
  },
  methods: {
    ...mapMutations([
      'setUnreadNotificationsCount',
      'incrementUnreadNotificationsCount'
    ]),
    ...mapActions([
      'getNotifications',
      'getNotification',
      'readNotifications'
    ]),
  },
  mounted() {
    this.setUnreadNotificationsCount(this.count)

    let userId = document.head.querySelector('meta[name="user-id"]')

    socket
      .private('App.User.' + userId.content)
      .notification(notification => {
        this.incrementUnreadNotificationsCount()

        if (this.user.notifications.length > 0) {
          this.getNotification(notification.id)
        }
      })

    var vm = this

    $('#notificationMenu').popup({
      on: 'click',
      position: 'bottom right',
      onShow() {
        if (vm.user.notifications.length == 0) {
          vm.getNotifications()

          return
        }

        if (vm.user.unreadNotificationsCount > 0) {
          vm.setUnreadNotificationsCount(0)
          vm.readNotifications()
        }
      }
    })
  }
}
</script>
