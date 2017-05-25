<template lang='jade'>
a#notificationMenu.item
  i.bell.outline.icon
  span.text Notifications
  .ui.tiny.top.right.attached.red.label(v-show="user.unreadNotificationsCount > 0")
    | {{ user.unreadNotificationsCount }}
</template>

<script>
import store from './../store'
import { mapState } from 'vuex'
import { mapMutations } from 'vuex'
import { mapActions } from 'vuex'

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
      'setUnreadNotificationsCount'
    ]),
    ...mapActions([
      'getNotifications',
      'readNotifications'
    ]),
  },
  mounted() {
    this.setUnreadNotificationsCount(this.count)

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
          vm.readNotifications();
        }
      }
    })
  }
}
</script>
