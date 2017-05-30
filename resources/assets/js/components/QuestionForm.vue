<template lang='jade'>
#questionForm.ui.small.modal
  i.close.icon
  .content
    .ui.form
      .field.required
        label Question
        input(name='body' type='text' placeholder='Write your question' v-model='payload.body')
      .field
        label Detail
        textarea(name='detail' rows='2' placeholder='Write detail if any' v-model='payload.detail')
      .field
        label Tags
        select.tags.ui.fluid.search.dropdown(name='tags[]' multiple v-model='payload.tags')
          option Tags
      .field.required.four.wide
        label Language
        select.language.ui.dropdown(name='language' v-model="payload.language")
          option(v-for="language in user.languages" ":value"="language.code") {{ language.name }}
      button.ui.green.tiny.button(:class='{ disabled: this.isDisabled }' @click='onSubmit')
        i.send.icon
        | Post Question
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import http from 'lib/http'

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
      'query',
      'user'
    ]),
    ...mapGetters([
      'preferredLanguage'
    ])
  },
  watch: {
    query() {
      this.payload.body = this.query
    }
  },
  methods: {
    ...mapActions([
      'getUserLanguages'
    ]),
    onSubmit() {
      this.disabled = true

      http.post('/api/questions', this.payload)
        .then(response => {
          window.location.replace(response.data.slug)
        })
        .catch(error => {
          this.disabled = false
        })
    }
  },
  mounted() {
    this.getUserLanguages().then(() => {
      // TODO: Remove if before production
      if (this.preferredLanguage) {
        $('#questionForm [name=language]').dropdown('set selected', this.preferredLanguage.code)
      }
    })

    $('#questionForm [name="tags[]"]').dropdown({
      allowAdditions: true,
      minCharacters: 1,
      // apiSettings: {
      //   url: '/api/topics/search?q={query}&language={language}',
      //   beforeSend (settings) {
      //     settings.urlData.language = $('.field .language select').val()
      //
      //     return settings
      //   }
      // }
    })
  }
}
</script>
