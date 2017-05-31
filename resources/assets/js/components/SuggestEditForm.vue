<template lang='jade'>
.suggestion.ui.small.modal
  .content
    .ui.form
      .field
        label Suggest edit to {{ answer.user.name }}'s answer
        textarea(name='body' placeholder='Write detail if any' v-model='payload.body')
      button.ui.green.tiny.button(
        :class='{ disabled: this.isDisabled || answer.body == payload.body }'
        @click='onSubmit'
      )
        i.send.icon
        | Post Edit Suggestion
</template>

<script>
import { mapState } from 'vuex'
import http from 'lib/http'

export default {
  props: ['answer'],
  data() {
    return {
      isDisabled: false,
      payload: {
        body: this.answer.body
      }
    }
  },
  computed: {
    ...mapState([
      'question'
    ])
  },
  methods: {
    onSubmit() {
      this.isDisabled = true

      http.post('/api/questions/' + this.question.id +'/answers/' + this.answer.id + '/edits', this.payload)
        .then(response => {
          this.isDisabled = false
          $('#answer-' + this.answer.id + ' .suggestion.modal').modal('hide')
          $('#successModal').modal('show')
        })
        .catch(error => {
          this.isDisabled = false
        })
    }
  }
}
</script>
