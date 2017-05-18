<template lang='jade'>
  #requestAnswerButton.ui.tiny.button(
    :class='requestAnswerButtonClass'
    @click='requestAnswerButtonClick'
  )
    strong {{ requestAnswerButtonText }}
</template>

<script>
import { mapState } from 'vuex'
import { mapActions } from 'vuex'

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
        return 'Requesting answer'
      }

      return 'Request answer'
    }
  },
  methods: {
    ...mapActions([
      'postAnswerRequest',
      'deleteAnswerRequest'
    ]),
    requestAnswerButtonClick() {
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
