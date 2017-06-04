<template lang='jade'>
.ui.raised.fluid.card(':id'='"answer-" + answer.id')
  .content
    strong {{ answer.user.name }}
    .meta
      a.date(:title='answer.updatedAt | formatDateTime') {{ answer.updatedAt | humanizeDateTime }}
    .description {{ answer.body }}
  .extra.content
      span.stat {{ $tc('Votes', answer.votesCount) }}
  .extra.content
    vote-answer-button(:answer='answer')
    button.more.ui.icon.top.left.pointing.dropdown.tiny.basic.right.floated.button
      i.vertical.ellipsis.icon
      .menu
        .suggest.item(@click='onSuggestEditButtonClick') {{ $t('Suggest Edit') }}
  suggest-edit-form(:answer='answer')
</template>

<script>
import { mapState } from 'vuex'
import VoteAnswerButton from 'components/VoteAnswerButton'
import SuggestEditForm from 'components/SuggestEditForm'

export default {
  props: ['answer'],
  components: {
    SuggestEditForm,
    VoteAnswerButton
  },
  computed: {
    ...mapState([
      'question'
    ])
  },
  methods: {
    onSuggestEditButtonClick() {
      if (this.$root.auth()) {
      $('#answer-' + this.answer.id + ' .suggestion.modal')
        .modal({ detachable: false })
        .modal("show")
      }
    }
  },
  mounted() {
    $('#answer-' + this.answer.id + ' .more').dropdown()
  }
}
</script>
