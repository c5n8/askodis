<template lang='jade'>
  button.ui.tiny.button(
    :class='voteAnswerButtonClass'
    @click='onVoteAnswerButtonClick'
  )
    i.check.icon
    strong {{ $t(voteAnswerButtonText) }}
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  props: ['question', 'answer'],
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
    // ...mapState([
    //   'question'
    // ]),
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
      'postQuestionAnswerVote',
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
        .postQuestionAnswerVote({ question: this.question, answer: this.answer})
        .then(() => this.isDisabled = false)
    }
  }
}
</script>
