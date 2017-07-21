<template lang='pug'>
#questionTranslationForm.ui.small.modal
  .content
    .ui.form
      .field.four.wide
        label {{ $t('Translate to') }}
        select.language.ui.dropdown(name='language' v-model="payload.language")
          template(v-if='isReady')
            option(v-for="language in languages" ":value"="language.code") {{ language.name }}
      .field
        label {{ $t('Question') }}
        p {{ question.body }}
        input(name='body' type='text' ':placeholder'='$t("Write question translation")' v-model='payload.body')
      .field
        label {{ $t('Detail') }}
        p {{ question.detail }}
        textarea(
          name='detail'
          rows='2'
          ':placeholder'='$t("Write detail translation if any or necessary in target language")'
          v-model='payload.detail'
        )
      .field
        label {{ $t('Tags') }}
      .field.inline(v-for='(tag, index) in question.tags')
        .ui.small.tag.label {{ tag.body }}
        input(:name='"tags[" + index + "][body]"' type='text' v-model='payload.tags[index].body')
      button.ui.green.tiny.button(:class='{ disabled: this.isDisabled }' @click='onSubmit')
        i.send.icon
        | {{ $t('Post Translation') }}
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
        body: '',
        detail: '',
        tags: [],
        language: null
      }
    }
  },
  computed: {
    ...mapState([
      'question',
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

      http.post('/api/questions/' + this.question.id + '/editions', this.payload)
        .then(response => {
          window.location.replace('/' + response.data.slug)
        })
        .catch(error => {
          this.disabled = false
        })
    }
  },
  updated() {
    if (this.user.languages.length > 0) {
      $('#questionTranslationForm [name=language]').dropdown('set selected', this.user.languages[0].code)
    }
  }
}
</script>
