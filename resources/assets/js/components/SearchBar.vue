<template lang='jade'>
  #searchBar.ui.category.search.item
    .ui.icon.input
      input.prompt(name='search' type='text' ':placeholder'='$t("What\'s your question?")' v-model='query')
      i.search.link.icon
    small#algoliaMessage.stat Powered by
    img(src='/img/algolia-logo.jpg')
    .results
    #noResultMessage(style='display: none')
      .message.empty
        .header {{ $t('No Results') }}
        .description {{ $t('Your search returned no results') }}
        .ui.hidden.divider
        button#writeQuestionButton.ui.tiny.basic.button
          i.edit.icon
          | {{ $t('Write New Question') }}
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import _ from 'lodash'
import QuestionForm from 'components/QuestionForm'

export default {
  components: {
    QuestionForm,
  },
  computed: {
    query: {
      get () {
        return this.$store.state.query
      },
      set (value) {
        this.setQuery(value)
      }
    }
  },
  methods: {
    ...mapMutations([
      'setQuery'
    ])
  },
  mounted() {
    var algolia = {
      id: 'P4U9L9Y88Q',
      key: 'dee73656ad7ee84bf96bc603738611bc',
      index: 'questions'
    }

    var vm = this

    $('#searchBar').search({
      minCharacters: 7,
      apiSettings: {
        method: 'post',
        url: 'https://' + algolia.id + '-dsn.algolia.net/1/indexes/' + algolia.index + '/query',
        beforeXHR (xhr) {
          xhr.setRequestHeader ('X-Algolia-API-Key', algolia.key)
          xhr.setRequestHeader ('X-Algolia-Application-Id', algolia.id)

          return xhr
        },
        beforeSend (settings) {
          settings.data = JSON.stringify({
            'params' : 'query=' + encodeURIComponent(settings.urlData.query) + '&hitsPerPage=5'
          })

          return settings
        },
        onResponse (response) {
          var results = _.map(response.hits, hit => {
            return {
              title: hit.body,
              url: '/' + hit.slug
            }
          })

          return { results: results }
        },
      },
      templates: {
        message(type, message) {
          return $('#noResultMessage').html()
        }
      }
    })

    $(document).on('click', '#writeQuestionButton', e => {
      if (this.$root.auth()) {
        $('#questionForm').modal('show')
      }
    })
  }
}
</script>

<style lang='stylus' scoped>
  #algoliaMessage
    margin-left: 5px
    min-width: 60px
</style>
