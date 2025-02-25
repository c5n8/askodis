<template lang="pug">
#requestQuestionTranslationForm.ui.small.modal
  .content
    .ui.form
      .field.four.wide
        label {{ $t('Translate to') }}
        select.language.ui.dropdown(name='language' v-model="payload.language")
          template(v-if='isReady')
            option(v-for="language in languages" ":value"="language.code") {{ language.name }}
      button.ui.green.tiny.button(:class='{ disabled: this.isDisabled }' @click='onSubmit')
        i.send.icon
        | {{ $t('Request Translation') }}
</template>

<script>
import { mapState, mapActions } from 'vuex'
import http from '../lib/http.js'
import _ from 'lodash'

export default {
  data() {
    return {
      isDisabled: false,
      payload: {
        language: null,
      },
    }
  },
  computed: {
    ...mapState(['question', 'user']),
    isReady() {
      if (this.user.languages.length == 0) {
        return false
      }

      if (_.isEmpty(this.question)) {
        return false
      }

      return true
    },
    languages() {
      return this.user.languages.filter((language) => {
        return language.code != this.question.language.code
      })
    },
  },
  methods: {
    ...mapActions(['getUserLanguages']),
    onSubmit() {
      this.isDisabled = true

      http
        .post(
          '/api/questions/' + this.question.id + '/translation_requests/',
          this.payload,
        )
        .then((response) => {
          this.isDisabled = false
          $('#requestQuestionTranslationForm.modal').modal('hide')
          $('#successModal').modal('show')
        })
        .catch((error) => {
          this.isDisabled = false
        })
    },
  },
  updated() {
    if (this.user.languages.length > 0) {
      $('#requestQuestionTranslationForm [name=language]').dropdown(
        'set selected',
        this.user.languages[0].code,
      )
    }
  },
}
</script>
