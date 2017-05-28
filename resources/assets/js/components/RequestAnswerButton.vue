<template lang='jade'>
  button.ui.tiny.button(
    :class='requestAnswerButtonClass'
    @click='onRequestAnswerButtonClick'
  )
    i.help.circle.icon
    strong {{ requestAnswerButtonText }}
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
    requestAnswerButtonClass() {
      return {
        basic: ! this.question.hasAnswerRequestFromCurrentUser,
        blue: this.question.hasAnswerRequestFromCurrentUser,
        disabled: this.isDisabled
      }
    },
    requestAnswerButtonText() {
      if (this.question.hasAnswerRequestFromCurrentUser) {
        return 'Asked'
      }

      return 'Ask'
    },
  },
  methods: {
    ...mapActions([
      'postAnswerRequest',
      'deleteAnswerRequest'
    ]),
    onRequestAnswerButtonClick() {
      this.isDisabled = true

      if (this.question.hasAnswerRequestFromCurrentUser) {
        this
          .deleteAnswerRequest()
          .then(() => this.isDisabled = false)

        return
      }

      this
        .postAnswerRequest()
        .then(() => this.isDisabled = false)
    }
  }
}
</script>
