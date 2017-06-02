<template lang='jade'>
  button.ui.tiny.button(
    :class='askButtonClass'
    @click='onAskButtonClick'
  )
    i.help.circle.icon
    strong {{ $t(askButtonText) }}
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
    ...mapState([
      'question'
    ]),
    askButtonClass() {
      return {
        basic: ! this.question.hasVoteFromCurrentUser,
        blue: this.question.hasVoteFromCurrentUser,
        disabled: this.isDisabled
      }
    },
    askButtonText() {
      if (this.question.hasVoteFromCurrentUser) {
        return 'Asked'
      }

      return 'Ask'
    },
  },
  methods: {
    ...mapActions([
      'postQuestionVote',
      'deleteVote'
    ]),
    onAskButtonClick() {
      this.isDisabled = true

      if (this.question.hasVoteFromCurrentUser) {
        this
          .deleteVote(this.question)
          .then(() => this.isDisabled = false)

        return
      }

      this
        .postQuestionVote()
        .then(() => this.isDisabled = false)
    }
  }
}
</script>
