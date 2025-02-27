<template lang="pug">
  #searchBar.ui.category.search.item
    .ui.icon.input
      input.prompt(name='search' type='text' ':placeholder'='$t("What is your question?")' v-model='query')
      i.search.link.icon
    small#algoliaMessage.stat powered by
    a(href='https://www.algolia.com' target='_blank')
      img#algoliaLogo(:src='algoliaLogo' height='12px')
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
import QuestionForm from './QuestionForm.vue'
import * as algolia from '@algolia/client-search'
import algoliaLogo from '../img/algolia-logo.jpg'

const searchClient = algolia.searchClient(
  import.meta.env.VITE_ALGOLIA_APP_ID,
  import.meta.env.VITE_ALGOLIA_SEARCH_KEY,
)

export default {
  components: {
    QuestionForm,
  },
  computed: {
    query: {
      get() {
        return this.$store.state.query
      },
      set(value) {
        this.setQuery(value)
      },
    },
  },
  methods: {
    ...mapMutations(['setQuery']),
  },
  mounted() {
    $('#searchBar').search({
      minCharacters: 1,
      apiSettings: {
        responseAsync: async (settings, callback) => {
          const response = await searchClient.searchSingleIndex({
            indexName: 'questions',
            searchParams: {
              query: settings.urlData.query,
            },
          })

          callback(response)
        },

        onResponse(response) {
          var results = _.map(response.hits, (hit) => {
            return {
              title: hit.body,
              url: '/' + hit.slug,
            }
          })

          return { results: results }
        },
      },
      templates: {
        message(type, message) {
          return $('#noResultMessage').html()
        },
      },
    })

    $(document).on('click', '#writeQuestionButton', (e) => {
      if (this.$root.auth()) {
        $('#questionForm').modal('show')
      }
    })
  },
}
</script>

<style lang="stylus" scoped>
#algoliaMessage
  margin-left: 5px
  min-width: 60px

#algoliaLogo
  margin-bottom: -1px
</style>
