<template lang='jade'>
#answerForm.ui.form
  .field(:class='{ disabled: this.isDisabled }')
    textarea(
      placeholder='Write your answer'
      ':autofocus'='isWritingAnswer'
      v-model='body'
    )
  .ui.tiny.green.button(:class='{ disabled: this.isDisabled }' @click='submit')
    i.send.icon
    | Post
</template>

<script>
import { mapState } from 'vuex'
import { mapActions } from 'vuex'

export default {
  props: ['isWritingAnswer'],
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
    ...mapState([
      'question'
    ]),
    body: {
      get () {
        if (! this.question.hasAnswerFromCurrentUser) {
          return
        }

        return this.question.answerFromCurrentUser.body
      },
      set (value) {
        this.$store.commit('setAnswerFromCurrentUserBody', value)
      }
    }
  },
  methods: {
    ...mapActions([
      'postAnswer',
      'patchAnswer'
    ]),
    submit() {
      this.isDisabled = true

      if (! this.question.hasAnswerFromCurrentUser) {
        this
          .postAnswer()
          .then(() => {
            this.isDisabled = false
            this.$emit('finishWritingAnswer')
          })
      }

      this
        .patchAnswer()
        .then(() => {
          this.isDisabled = false
          this.$emit('finishWritingAnswer')
        })
    }
  }
}
</script>
