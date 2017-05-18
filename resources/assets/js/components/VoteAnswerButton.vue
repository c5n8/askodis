<template lang='jade'>
  .vote.ui.tiny.button(
    :class='voteAnswerButtonClass'
    @click='voteAnswerButtonClick'
  )
    i.check.icon
    strong {{ voteAnswerButtonText }}
</template>

<script>
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'

export default {
  props: ['id'],
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
    ...mapGetters([
      'getAnswerById',
    ]),
    answer() {
      return this.getAnswerById(this.id)
    },
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
    voteAnswerButtonClick() {
      this.isDisabled = true

      if (this.answer.hasVoteFromCurrentUser) {
        this
          .deleteAnswerVote(this.id)
          .then(() => this.isDisabled = false)

        return
      }

      this
        .postAnswerVote(this.id)
        .then(() => this.isDisabled = false)
    }
  }
}
</script>
