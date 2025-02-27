<template lang='pug'>
.answer.ui.small.modal
  .content
    form.ui.form(@submit.prevent='onSubmit')
      .field(:class='{ disabled: this.isDisabled }')
        textarea(
          ':placeholder'='$t("Write your answer")'
          ':autofocus'='isWritingAnswer'
          v-model='body'
        )
      button.ui.tiny.green.button(type='submit' ':class'='{ disabled: this.isDisabled }')
        i.send.icon
        | {{ $t('Post Answer') }}
</template>

<script>
import { mapMutations, mapActions } from 'vuex'

export default {
  props: ['question', 'isWritingAnswer'],
  data() {
    return {
      isDisabled: false
    }
  },
  computed: {
    body: {
      get () {
        if (! this.question.hasAnswerFromCurrentUser) {
          return
        }

        return this.question.answerFromCurrentUser.body
      },
      set (value) {
        this.setAnswerFromCurrentUserBody({ question: this.question, body: value })
      }
    }
  },
  methods: {
    ...mapMutations([
      'setAnswerFromCurrentUserBody'
    ]),
    ...mapActions([
      'postQuestionAnswer',
      'patchQuestionAnswer'
    ]),
    onSubmit() {
      this.isDisabled = true

      if (! this.question.hasAnswerFromCurrentUser) {
        this.postQuestionAnswer(this.question).then(() => {
          this.isDisabled = false
          this.question.hasAnswer = true
          $('#question-' + this.question.id + ' .answer.modal').modal("hide")
        })

        return
      }

      this.patchQuestionAnswer({ question: this.question, answer: this.question.answerFromCurrentUser })
        .then(() => {
          this.isDisabled = false
          $('#question-' + this.question.id + ' .answer.modal').modal("hide")
        })
    }
  }
}
</script>
