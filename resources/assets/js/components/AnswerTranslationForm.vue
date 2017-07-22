<template lang='jade'>
.translation.ui.small.modal
  .content
    .ui.form
      .field.four.wide
        label {{ $t('Translate to') }}
        select.language.ui.dropdown(name='language' v-model="payload.language")
          template(v-if='isReady')
            option(v-for="language in languages" ":value"="language.code") {{ language.name }}
      .field
        p {{ answer.body }}
        textarea(
          name='body'
          rows='2'
          ':placeholder'='$t("Write answer translation")'
          v-model='payload.body'
        )
      button.ui.green.tiny.button(:class='{ disabled: this.isDisabled }' @click='onSubmit')
        i.send.icon
        | {{ $t('Post Translation') }}
</template>

<script>
import { mapState, mapActions } from 'vuex'
import http from 'lib/http'
import _ from 'lodash'

export default {
  props: ['answer', 'question'],
  data() {
    return {
      isDisabled: false,
      payload: {
        detail: '',
        language: null
      }
    }
  },
  computed: {
    ...mapState([
      'user'
    ]),
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
      return this.user.languages.filter(language => {
        return language.code != this.question.language.code
      })
    }
  },
  watch: {
    question() {
      for (var i = 0; i < this.question.tags.length; i++) {
        this.payload.tags.push({
          id: this.question.tags[i].id,
          body: ''
        })
      }
    }
  },
  methods: {
    ...mapActions([
      'getUserLanguages'
    ]),
    onSubmit() {
      this.disabled = true

      http.post('/api/questions/' + this.question.id + '/answers/' + this.answer.id + '/editions', this.payload)
        .then(response => {
          this.isDisabled = false
          $('#answer-' + this.answer.id + ' .translation.modal').modal('hide')
          $('#successModal').modal('show')
        })
        .catch(error => {
          this.disabled = false
        })
    }
  },
  updated() {
    if (this.languages.length > 0) {
      $('#answer-' + this.answer.id + ' .translation.modal [name=language]').dropdown('set selected', this.languages[0].code)
    }
  }
}
</script>
