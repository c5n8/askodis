<template lang='jade'>
a.item(':href'='notification.data.action')
  .content
    .description
      span {{ notification.data.message }}
      span {{ '. ' }}
      //- a.user Elliot Fu
      //- | {{ ' added you as a friend' }}
      span.right.floated.stat(:title='formattedDateTime') {{ humanizedDateTime }}
</template>

<script>
export default {
  props: ['notification'],
  computed: {
    humanizedDateTime() {
      return moment
      .utc(this.notification.createdAt)
      .utcOffset(moment().utcOffset())
      .fromNow()
    },
    formattedDateTime() {
      return moment
      .utc(this.notification.createdAt)
      .utcOffset(moment().utcOffset())
      .format('DD MMMM YYYY HH:mm')
    }
  }
}
</script>
