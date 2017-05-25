<template lang='jade'>
.ui.flowing.popup
  #notificationList.ui.divided.relaxed.link.list(@scroll='handleNotificationListScroll')
    notification-item(
      :notification='notification'
      v-for='notification in user.notifications'
      ':key'='notification.id'
    )

    template(v-if='user.hasReadAllNotifications')
      .item(style='text-align: center')
        .content
          .description
            span.stat {{ endText }}

    .ui.mini.centered.inline.loader(:class='{ active: ! user.hasReadAllNotifications }')
</template>

<script>
import store from './../store'
import { mapState } from 'vuex'
import { mapActions } from 'vuex'
import NotificationItem from './NotificationItem.vue'

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
    handleNotificationListScroll() {
      var list = $("#notificationList")

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
