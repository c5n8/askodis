<template lang='jade'>
.ui.flowing.popup
  #notificationList.ui.divided.relaxed.link.list(@scroll='onNotificationListScroll')
    notification-item(
      :notification='notification'
      v-for='notification in user.notifications'
      ':key'='notification.id'
    )

    .item(v-if='user.hasReadAllNotifications' style='text-align: center')
      .content
        .description
          span.stat {{ endText }}

    .ui.mini.centered.inline.loader(:class='{ active: ! user.hasReadAllNotifications }')
</template>

<script>
import { mapState, mapActions } from 'vuex'
import store from 'store'
import NotificationItem from 'components/NotificationItem'

export default {
  store,
  components: {
    NotificationItem
  },
  data() {
    return {
      isLoadingMoreNotifications: false
    }
  },
  computed: {
    ...mapState([
      'user'
    ]),
    endText() {
      if (this.user.notifications.length == 0) {
        return 'No notification yet'
      }

      return 'That\'s all'
    }
  },
  methods: {
    ...mapActions([
      'getOlderNotifications'
    ]),
    onNotificationListScroll() {
      var list = $('#notificationList')

      if(list.scrollTop() >= (list[0].scrollHeight - list.outerHeight()))
      {
        if (this.isLoadingMoreNotifications) {
          return
        }

        if (this.user.hasReadAllNotifications) {
          return
        }

        this.isLoadingMoreNotifications = true

        this
          .getOlderNotifications()
          .then(() => {
            this.isLoadingMoreNotifications = false
          })
      }
    }
  }
}
</script>

<style lang='stylus' scoped>
.popup
  min-width: 360px
  max-width: 360px

#notificationList
  max-height: 250px
  overflow: hidden
  overflow-y: scroll
  padding: 10px
</style>
