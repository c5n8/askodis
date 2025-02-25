<template lang="pug">
#questionTranslationRequestForm.ui.small.modal
  .content
    form.ui.form(@submit.prevent='onSubmit')
      .field.four.wide
        label {{ $t('Select Language') }}
        select.language.ui.dropdown(name='language' v-model="payload.language")
          template(v-if='isReady')
            option(v-for="language in languages" ":value"="language.code") {{ language.name }}
      button.ui.green.tiny.button(type='submit' ':class'='{ disabled: this.isDisabled }')
        i.send.icon
        | {{ $t('Send Request') }}
</template>

<script>
import { mapState, mapActions } from 'vuex'
import http from 'lib/http'
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
      return this.$store.state.languages.filter((language) => {
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
          '/api/questions/' + this.question.id + '/translation_requests',
          this.payload,
        )
        .then((response) => {
          this.isDisabled = false
          $('#questionTranslationRequestForm').modal('hide')
          $('#successModal').modal('show')
        })
        .catch((error) => {
          this.isDisabled = false
        })
    },
  },
  updated() {
    if (this.user.languages.length > 0) {
      $('#questionTranslationRequestForm [name=language]').dropdown(
        'set selected',
        this.languages[0].code,
      )
    }
  },
}
</script>
