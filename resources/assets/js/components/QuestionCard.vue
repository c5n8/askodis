<template lang='jade'>
.ui.fluid.card(':id'='"answer-" + question.topAnswer.id')
  .content
    h3
      a(
        :href='question.slug'
        style='color: black'
        target='_blank'
      ) {{ question.body }}

    strong {{ question.topAnswer.user.name }}
    .meta
      a.date(:title='question.topAnswer.updatedAt | formatDateTime') {{ question.topAnswer.updatedAt | humanizeDateTime }}
    .description {{ question.topAnswer.body }}
  .extra.content
      span.stat {{ $tc('Votes', question.topAnswer.votesCount) }}
  .extra.content
    vote-answer-button(:answer='question.topAnswer' ':question'='question')
    button.more.ui.icon.top.left.pointing.dropdown.tiny.basic.right.floated.button
      i.vertical.ellipsis.icon
      .menu
        .suggest.item(@click='onSuggestEditButtonClick') {{ $t('Suggest Edit') }}
  suggest-edit-form(:answer='question.topAnswer' ':question'='question')
</template>

<script>
import VoteAnswerButton from 'components/VoteAnswerButton'
import SuggestEditForm from 'components/SuggestEditForm'

export default {
  props: ['question'],
  components: {
    SuggestEditForm,
    VoteAnswerButton
  },
  methods: {
    onSuggestEditButtonClick() {
      if (this.$root.auth()) {
        $('#answer-' + this.question.topAnswer.id + ' .suggestion.modal')
          .modal({ detachable: false })
          .modal("show")
      }
    }
  },
  mounted() {
    $('#answer-' + this.question.topAnswer.id + ' .more').dropdown()
  }
}
</script>
