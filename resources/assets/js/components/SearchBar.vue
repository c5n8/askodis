<template lang='jade'>
  #searchBar.ui.category.search.item
    .ui.icon.input
      input.prompt(name='search' type='text' placeholder='Search questions' v-model='query')
      i.search.link.icon
    .results
    #noResultMessage(style='display: none')
      .message.empty
        .header No Results
        .description Your search returned no results
        .ui.hidden.divider
        .ui.tiny.basic.button(onclick='$("#questionForm").modal({blurring: true}).modal("show")')
          i.edit.icon
          | Write New Question

    question-form(:body='query')
</template>

<script>
import _ from 'lodash'
import QuestionForm from 'components/QuestionForm'

export default {
  components: {
    QuestionForm,
  },
  data() {
    return {
      query: ''
    }
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

          return { results : results }
        },
      },
      templates: {
        message(type, message) {
          return $('#noResultMessage').html()
        }
      }
    })
  }
}
</script>
