<template lang="jade">
  #searchBar.ui.category.search.item
    .ui.icon.input
      input.prompt(name="search" type="text" placeholder="Search questions")
      i.search.link.icon
    .results
</template>

<script>
export default {
  // data() {
  //   return {
  //     hasEmptyResult: false
  //   }
  // },
  mounted() {
    var algolia = {
      id: "P4U9L9Y88Q",
      key: "dee73656ad7ee84bf96bc603738611bc",
      index: "questions"
    }

    var vm = this

    $('#searchBar').search({
      minCharacters: 10,
      apiSettings: {
        method: 'post',
        url: 'https://' + algolia.id + '-dsn.algolia.net/1/indexes/' + algolia.index + '/query',
        beforeXHR (xhr) {
          xhr.setRequestHeader ('X-Algolia-API-Key', algolia.key)
          xhr.setRequestHeader ('X-Algolia-Application-Id', algolia.id)

          return xhr
        },
        beforeSend (settings) {
          // if (settings.urlData.query.length > 10 && ! vm.hasEmptyResult) {
          //   return false
          // }

          settings.data = JSON.stringify({
            "params" : "query=" + encodeURIComponent(settings.urlData.query) + "&hitsPerPage=5"
          })

          return settings
        },
        onResponse (algoliaResponse) {
          var response = { results : [] }

          // if (algoliaResponse.nbHits == 0) {
          //   vm.hasEmptyResult = false
          //
          //   return response
          // }

          // vm.hasEmptyResult = true

          $.each(algoliaResponse.hits, (index, item) => response.results.push({
              title: item.body,
              url: "/" + item.slug
          }))

          return response
        },
      }
    })
  }
}
</script>
