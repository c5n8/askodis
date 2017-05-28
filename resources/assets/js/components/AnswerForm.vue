<template lang='jade'>
form#answerForm.ui.form(@submit.prevent='onSubmit')
  .field(:class='{ disabled: this.isDisabled }')
    textarea(
      placeholder='Write your answer'
      ':autofocus'='isWritingAnswer'
      v-model='body'
    )
  button.ui.tiny.green.button(type='submit' ':class'='{ disabled: this.isDisabled }')
    i.send.icon
    | Post
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

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
        this.setAnswerFromCurrentUserBody(value)
      }
    }
  },
  methods: {
    ...mapMutations([
      'setAnswerFromCurrentUserBody'
    ]),
    ...mapActions([
      'postAnswer',
      'patchAnswer'
    ]),
    onSubmit() {
      this.isDisabled = true

      if (! this.question.hasAnswerFromCurrentUser) {
        this.postAnswer().then(() => {
          this.isDisabled = false
          this.$emit('finishWritingAnswer')
        })

        return
      }

      this.patchAnswer().then(() => {
        this.isDisabled = false
        this.$emit('finishWritingAnswer')
      })
    }
  }
}
</script>
