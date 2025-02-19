<script setup>
import algoliaLogo from '../assets/algolia-logo.jpg'
import { onMounted } from 'vue'
import { searchClient } from '@algolia/client-search'

onMounted(() => {
  $('#searchBar').search({
    minCharacters: 1,

    apiSettings: {
      responseAsync: async (settings, callback) => {
        const response = await searchClient(
          import.meta.env.VITE_ALGOLIA_APP_ID,
          import.meta.env.VITE_ALGOLIA_SEARCH_KEY,
        ).searchSingleIndex({
          indexName: 'questions',
          searchParams: {
            query: settings.urlData.query,
          },
        })

        callback(response)
      },

      onResponse: (response) => {
        const results = response.hits.map((hit) => ({
          title: hit.body,
          url: '/' + hit.slug,
        }))

        return { results }
      },
    },

    templates: {
      message: () => $('#noResultMessage').html(),
    },
  })

  $(document).on('click', '#writeQuestionButton', () => {
    if (this.$root.auth()) {
      $('#questionForm').modal('show')
    }
  })
})
</script>

<script>
import { mapMutations } from 'vuex'

export default {
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
}
</script>

<template>
  <div class="ui category search item" id="searchBar">
    <div class="ui icon input">
      <input
        v-model="query"
        :placeholder="$t('What is your question?')"
        class="prompt"
        name="search"
        type="text"
      /><i class="search link icon"></i>
    </div>
    <small class="stat" id="algoliaMessage">powered by</small>
    <a href="https://www.algolia.com" target="_blank">
      <img id="algoliaLogo" :src="algoliaLogo" height="12px" />
    </a>
    <div class="results"></div>
    <div id="noResultMessage" style="display: none">
      <div class="message empty">
        <div class="header">{{ $t('No Results') }}</div>
        <div class="description">
          {{ $t('Your search returned no results') }}
        </div>
        <div class="ui hidden divider"></div>
        <button class="ui tiny basic button" id="writeQuestionButton">
          <i class="edit icon"></i>{{ $t('Write New Question') }}
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
#algoliaMessage {
  margin-left: 5px;
  min-width: 60px;
}

#algoliaLogo {
  margin-bottom: -1px;
}
</style>
