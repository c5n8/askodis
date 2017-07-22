<template lang='jade'>
a.item(':href'='notification.data.url')
  .content
    .description
      span
        strong {{ notification.data.actor }}
      span {{ ' ' }}
      span {{ $t(notification.data.message) }}
      span {{ '. ' }}
    .description
      i.icon(:class='notificationItemIconClass')
      small.stat(:title='notification.createdAt | formatDateTime')
        | {{ notification.createdAt | humanizeDateTime }}
</template>

<script>
export default {
  props: ['notification'],
  computed: {
    notificationItemIconClass() {
      switch (this.notification.type) {
        case 'App\\Notifications\\AnswerEditionCreated':
        case 'App\\Notifications\\AnswerCreated':
          return { edit: true, black: true }

        case 'App\\Notifications\\AnswerVoteCreated':
          return { check: true, green: true }

        case 'App\\Notifications\\EditionUpdated':
          if (this.notification.data.message.startsWith('accepted')) {
            return { check: true, green: true }
          }

          return { cancel: true, red: true }
      }
    }
  }
}
</script>
