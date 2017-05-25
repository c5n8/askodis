<template lang='jade'>
.ui.raised.fluid.card(':id'='"answer-" + answer.id')
  .content
    strong {{ answer.user.name }}
    .right.floated
      i.angle.down.icon
    .meta
      span.date(:title='formattedDateTime') {{ humanizedDateTime }}
    .description {{ answer.body }}
  .extra.content
      span.stat {{ answer.votesCount }} Votes
      span.stat.right.floated 0 Comments
  .extra.content
    vote-answer-button(
      :answer='answer'
    )
    //- .ui.tiny.basic.button
    //-   i.comment.icon
    //-   strong Comment
    //- .ui.tiny.basic.button
    //-   i.share.icon
    //-   strong Share
    //- .ui.tiny.basic.icon.button.right.floated
    //-   i.ellipsis.vertical.icon
</template>

<script>
import VoteAnswerButton from './VoteAnswerButton.vue'

export default {
  props: ['answer'],
  components: {
    VoteAnswerButton
  },
  computed: {
    humanizedDateTime() {
      return moment
      .utc(this.answer.updatedAt)
      .utcOffset(moment().utcOffset())
      .fromNow()
    },
    formattedDateTime() {
      return moment
      .utc(this.answer.updatedAt)
      .utcOffset(moment().utcOffset())
      .format('DD MMMM YYYY HH:mm')
    }
  }
}
</script>
