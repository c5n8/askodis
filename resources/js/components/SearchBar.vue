<script setup>
import algoliaLogo from '../assets/algolia-logo.jpg'
import { getCurrentInstance, onMounted, reactive } from 'vue'
import * as algolia from '@algolia/client-search'

const vm = getCurrentInstance()

const refs = reactive({
  searchBar: undefined,
  noResultsMessage: undefined,
})

const searchClient = algolia.searchClient(
  import.meta.env.VITE_ALGOLIA_APP_ID,
  import.meta.env.VITE_ALGOLIA_SEARCH_KEY,
)

onMounted(() => {
  $(refs.searchBar).search({
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

      onResponse: (response) => {
        const results = response.hits.map((hit) => ({
          title: hit.body,
          url: `/${hit.slug}`,
        }))

        return { results }
      },
    },

    templates: {
      message: () => $(refs.noResultsMessage).html(),
    },
  })
})

$(() => {
  $(document).on('click', '[data-on-click="writeNewQuestion"]', () => {
    if (vm.proxy.$root.auth()) {
      $('#questionForm').modal('show')
    }
  })
})
</script>

<template>
  <div :ref="(el) => (refs.searchBar = el)" class="ui category search item">
    <div class="ui icon input">
      <input
        :placeholder="$t('What is your question?')"
        class="prompt"
        name="search"
        type="text"
      /><i class="search link icon"></i>
    </div>
    <small class="stat" style="margin-left: 5px; min-width: 60px">
      powered by
    </small>
    <a href="https://www.algolia.com" target="_blank">
      <img :src="algoliaLogo" style="margin-bottom: -1px" height="12px" />
    </a>
    <div class="results"></div>
    <div :ref="(el) => (refs.noResultsMessage = el)" style="display: none">
      <div class="message empty">
        <div class="header">{{ $t('No Results') }}</div>
        <div class="description">
          {{ $t('Your search returned no results') }}
        </div>
        <div class="ui hidden divider"></div>
        <button data-on-click="writeNewQuestion" class="ui tiny basic button">
          <i class="edit icon"></i>{{ $t('Write New Question') }}
        </button>
      </div>
    </div>
  </div>
</template>
