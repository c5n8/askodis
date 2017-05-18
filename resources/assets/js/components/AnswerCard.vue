<template lang='jade'>
.ui.raised.fluid.card(':id'='"answer-" + answer.id')
  .content
    strong {{ answer.user.name }}
    .meta
      span.date(:title='formattedDateTime') {{ humanizedDateTime }}
    .description {{ answer.body }}
  .extra.content
    .stat {{ answer.votesCount }} Votes
  .extra.content
    vote-answer-button(
      :answer='answer'
    )
</template>

<script>
import { mapState } from 'vuex'
import VoteAnswerButton from './VoteAnswerButton.vue'

export default {
  props: ['answer'],
  components: {
    VoteAnswerButton
  },
  computed: {
    ...mapState([
      'question'
    ]),
    humanizedDateTime() {
      return moment
      .utc(this.answer.updatedAt)
      .utcOffset(moment().utcOffset())
      .fromNow()
    },
    formattedDateTime(dateTime) {
      return moment
      .utc(this.answer.updatedAt)
      .utcOffset(moment().utcOffset())
      .format('DD MMMM YYYY HH:mm')
    }
  }
}
</script>
