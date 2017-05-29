<template lang='jade'>
#questionForm.ui.small.modal
  i.close.icon
  .content
    .ui.form
      .field.required
        label Question
        input(name='body' type='text' placeholder='Write your question' v-model='body')
      .field
        label Detail
        textarea(name='detail' rows='2' placeholder='Write detail if any' v-model='detail')
      .field
        label Tags
        select.tags.ui.fluid.search.dropdown(name='tags[]' multiple v-model='tags')
          option Tags
      .field.required.four.wide
        label Language
        select.language.ui.dropdown(name='language' v-model="language")
          option(v-for="language in user.languages" ":value"="language.code") {{ language.name }}
      button.ui.green.tiny.button(@click='onSubmit')
        i.send.icon
        | Post Question
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import http from 'lib/http'

export default {
  data() {
    return {
      body: '',
      detail: '',
      tags: [],
      language: null
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
      this.body = this.query
    }
  },
  methods: {
    ...mapActions([
      'getUserLanguages'
    ]),
    onSubmit() {
      http.post('/api/questions', this.$data).then(response => {
        window.location.replace(response.data.slug)
      })
    }
  },
  mounted() {
    this.getUserLanguages().then(() => {
      $('#questionForm [name=language]').dropdown('set selected', this.preferredLanguage.code)
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
