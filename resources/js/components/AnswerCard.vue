<template lang="pug">
.ui.raised.fluid.card(':id'='"answer-" + answer.id')
  .content
    strong
      a.userlink(:href='"/@" + answer.user.username') {{ answer.user.name }}
    span {{ ' ' }}
    span.stat
      a.userlink(:href='"/@" + answer.user.username') @{{ answer.user.username }}
    .meta
      a.date(:title='answer.updatedAt | formatDateTime') {{ answer.updatedAt | humanizeDateTime }}
    .description {{ answer.body }}
  .extra.content
      span {{ $tc('Votes', answer.votesCount) }}
  .content
    vote-answer-button(:answer='answer' ':question'='question')
    share-button(':shareUrl'='answer.shareUrl')
    button.more.ui.icon.top.left.pointing.dropdown.tiny.basic.right.floated.button
      i.vertical.ellipsis.icon
      .menu
        .suggest.item(@click='openSuggestionForm')
          i.edit.icon
          | {{ $t('Suggest Edit') }}
        .translate.item(@click='openTranslationForm')
          i.translate.icon
          | {{ $t('Translate') }}
        .request.translation.item(@click='openRequestTranslationForm')
          i.translate.icon
          | {{ $t('Request Translation') }}
  suggest-edit-form(:answer='answer' ':question'='question')
  answer-translation-form(:answer='answer' ':question'='question')
  request-answer-translation-form(:answer='answer' ':question'='question')
</template>

<script>
import { mapState } from 'vuex'
import VoteAnswerButton from './VoteAnswerButton.vue'
import ShareButton from './ShareButton.vue'
import SuggestEditForm from './SuggestEditForm.vue'
import AnswerTranslationForm from './AnswerTranslationForm.vue'
import RequestAnswerTranslationForm from './RequestAnswerTranslationForm.vue'

export default {
  props: ['answer'],
  components: {
    SuggestEditForm,
    ShareButton,
    VoteAnswerButton,
    RequestAnswerTranslationForm,
    AnswerTranslationForm,
  },
  computed: {
    ...mapState(['question']),
  },
  methods: {
    openSuggestionForm() {
      if (this.$root.auth()) {
        $('#answer-' + this.answer.id + ' .suggestion.modal')
          .modal({ detachable: false })
          .modal('show')
      }
    },
    openTranslationForm() {
      if (this.$root.auth()) {
        $('#answer-' + this.answer.id + ' .suggest.translation.modal')
          .modal({ detachable: false })
          .modal('show')
      }
    },
    openRequestTranslationForm() {
      if (this.$root.auth()) {
        $('#answer-' + this.answer.id + ' .request.translation.modal')
          .modal({ detachable: false })
          .modal('show')
      }
    },
  },
  mounted() {
    $('#answer-' + this.answer.id + ' .more').dropdown()
  },
}
</script>

<style lang="stylus" scoped>
.userlink
  color black
  &:hover
    color black
</style>
