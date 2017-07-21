<template lang='pug'>
.suggestion.ui.small.modal
  .content
    .ui.form
      .field
        label {{ $t('Suggest edit to answer', { name: answer.user.name}) }}
        textarea(name='body' v-model='payload.body')
      button.ui.green.tiny.button(
        :class='{ disabled: this.isDisabled || answer.body == payload.body }'
        @click='onSubmit'
      )
        i.send.icon
        | {{ $t('Post Edit Suggestion') }}
</template>

<script>
import http from 'lib/http'

export default {
  props: ['question', 'answer'],
  data() {
    return {
      isDisabled: false,
      payload: {
        body: this.answer.body
      }
    }
  },
  methods: {
    onSubmit() {
      this.isDisabled = true

      http.patch('/api/questions/' + this.question.id +'/answers/' + this.answer.id, this.payload)
        .then(response => {
          this.isDisabled = false
          $('.suggestion.modal').modal('hide')
          $('#successModal').modal('show')
        })
        .catch(error => {
          this.isDisabled = false
        })
    }
  }
}
</script>
