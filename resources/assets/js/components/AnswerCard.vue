<template lang='jade'>
.ui.raised.fluid.card(':id'='"answer-" + answer.id')
  .content
    strong {{ answer.user.name }}
    .meta
      a.date(:title='answer.updatedAt | formatDateTime') {{ answer.updatedAt | humanizeDateTime }}
    .description {{ answer.body }}
  .extra.content
      span.stat {{ answer.votesCount }} Votes
  .extra.content
    vote-answer-button(:answer='answer')
</template>

<script>
import VoteAnswerButton from 'components/VoteAnswerButton'

export default {
  props: ['answer'],
  components: {
    VoteAnswerButton
  }
}
</script>
