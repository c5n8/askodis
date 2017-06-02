<template lang='jade'>
.ui.flowing.popup

  .stat(
    v-if='user.hasReadAllNotifications && user.notifications == 0'
    style='text-align: center'
  ) {{ $t('No notification yet') }}

  .ui.mini.centered.inline.loader(
    v-else-if='user.notifications == 0'
    ':class'='{ active: ! user.hasReadAllNotifications && user.notifications == 0}'
  )

  #notificationList.ui.divided.relaxed.link.list(
    v-else
    @scroll='onNotificationListScroll'
  )
    notification-item(
      :notification='notification'
      v-for='notification in user.notifications'
      ':key'='notification.id'
    )

    .item(v-if='user.hasReadAllNotifications' style='text-align: center')
      .content
        .description
          span.stat {{ $t('That\'s all') }}

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
    ])
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
