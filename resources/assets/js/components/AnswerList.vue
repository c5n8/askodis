<template lang='jade'>
.ui.cards
  .ui.raised.fluid.card(v-for='answer in question.answers' ':key'='answer.id')
    .content
      strong {{ answer.user.name }}
      .meta
        span.date(:title='formatDateTime(answer.updatedAt)') {{ humanizeDateTime(answer.updatedAt) }}
      .description {{ answer.body }}
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState([
      'question'
    ]),
  },
  methods: {
    humanizeDateTime(dateTime) {
      return moment
        .utc(dateTime)
        .utcOffset(moment().utcOffset())
        .fromNow()
    },
    formatDateTime(dateTime) {
      return moment
        .utc(dateTime)
        .utcOffset(moment().utcOffset())
        .format('DD MMMM YYYY HH:mm')
    }
  }
}
</script>
