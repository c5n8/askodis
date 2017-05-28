<template lang='jade'>
  button.ui.tiny.button(
    :class='voteAnswerButtonClass'
    @click='onVoteAnswerButtonClick'
  )
    i.check.icon
    strong {{ voteAnswerButtonText }}
</template>

<script>
import { mapActions } from 'vuex'

export default {
  props: ['answer'],
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
    voteAnswerButtonClass() {
      return {
        basic: ! this.answer.hasVoteFromCurrentUser,
        blue: this.answer.hasVoteFromCurrentUser,
        disabled: this.isDisabled
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
      'deleteAnswerVote'
    ]),
    onVoteAnswerButtonClick() {
      this.isDisabled = true

      if (this.answer.hasVoteFromCurrentUser) {
        this
          .deleteAnswerVote(this.answer)
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
