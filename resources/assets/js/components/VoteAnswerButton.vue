<template lang='jade'>
  button.ui.tiny.button(
    :class='voteAnswerButtonClass'
    @click='onVoteAnswerButtonClick'
  )
    i.check.icon
    strong {{ voteAnswerButtonText }}
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  props: ['answer'],
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
    ...mapState([
      'question'
    ]),
    voteAnswerButtonClass() {
      return {
        basic: ! this.answer.hasVoteFromCurrentUser,
        blue: this.answer.hasVoteFromCurrentUser,
        disabled: this.isDisabled || (this.question.hasAnswerFromCurrentUser ? this.answer.id == this.question.answerFromCurrentUser.id : false)
      }
    },
    voteAnswerButtonText() {
      if (this.answer.hasVoteFromCurrentUser) {
        return 'Voted'
      }

      return 'Vote'
    }
  },
  methods: {
    ...mapActions([
      'postAnswerVote',
      'deleteVote'
    ]),
    onVoteAnswerButtonClick() {
      this.isDisabled = true

      if (this.answer.hasVoteFromCurrentUser) {
        this
          .deleteVote(this.answer)
          .then(() => this.isDisabled = false)

        return
      }

      this
        .postAnswerVote(this.answer)
        .then(() => this.isDisabled = false)
    }
  }
}
</script>
