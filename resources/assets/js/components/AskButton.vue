<template lang='pug'>
  button.ui.tiny.button(
    :class='askButtonClass'
    @click='onAskButtonClick'
  )
    i.help.circle.icon
    strong {{ $t(askButtonText) }}
</template>

<script>
import { mapActions } from 'vuex'

export default {
  props: ['question'],
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
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
        .postQuestionVote(this.question)
        .then(() => this.isDisabled = false)
        .catch(() => this.isDisabled = false)
    }
  }
}
</script>
