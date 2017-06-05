<template lang='jade'>
.ui.fluid.card(':id'='"question-" + question.id')
  .content
    h3
      a(
        :href='question.slug'
        style='color: black'
        target='_blank'
      ) {{ question.body }}

    template(v-if='! question.hasAnswer')
      p(v-if='question.hasDetail') {{ question.detail}}

      span.stat {{ question.createdAt | humanizeDateTime}}

      p
        .ui.tiny.tag.labels
          .ui.label(v-for='tag in question.tags') {{ tag.body }}

      p
        .stat {{ $tc('People ask', question.votesCount) }}

      ask-button(:question='question')
      button.ui.tiny.basic.button(@click='onAnswerButtonClick')
        i.edit.icon
        strong {{ $t(answerButtonText) }}
      share-button(:shareable='question')
      a.ui.tiny.basic.button(
        :href='question.slug'
        target='_blank'
      )
        i.external.icon
        strong {{ $t('More') }}
      button.question.more.ui.icon.top.left.pointing.dropdown.tiny.basic.right.floated.button
        i.vertical.ellipsis.icon
        .menu
          .translate.item(@click='onTranslateButtonClick')
            i.translate.icon
            | {{ $t('Translate') }}

      answer-form-modal(':question'='question')
      question-translation-form-modal(':question'='question')

  template(v-if="question.hasAnswer")
    .content.answer
      strong {{ question.topAnswer.user.name }}
      .meta
        a.date(:title='question.topAnswer.updatedAt | formatDateTime') {{ question.topAnswer.updatedAt | humanizeDateTime }}
      .description {{ question.topAnswer.body }}
    .extra.content
        span.stat {{ $tc('Votes', question.topAnswer.votesCount) }}
    suggest-edit-form(:answer='question.topAnswer' ':question'='question')

  .content(v-show="question.hasAnswer")
    template(v-if="question.hasAnswer")
      vote-answer-button(:answer='question.topAnswer' ':question'='question')
      share-button(':shareable'='question.topAnswer')
      a.ui.tiny.basic.button(
        :href='question.slug'
        target='_blank'
      )
        i.external.icon
        strong {{ $t('More') }}

    button.answer.more.ui.icon.top.left.pointing.dropdown.tiny.basic.right.floated.button
      i.vertical.ellipsis.icon
      .menu
        .suggest.item(@click='onSuggestEditButtonClick')
          i.edit.icon
          | {{ $t('Suggest Edit') }}
</template>

<script>
import VoteAnswerButton from 'components/VoteAnswerButton'
import SuggestEditForm from 'components/SuggestEditForm'
import QuestionTranslationFormModal from 'components/QuestionTranslationFormModal'
import AskButton from 'components/AskButton'
import ShareButton from 'components/ShareButton'

export default {
  props: ['question'],
  components: {
    QuestionTranslationFormModal,
    SuggestEditForm,
    VoteAnswerButton,
    AskButton,
    ShareButton
  },
  computed: {
    answerButtonText() {
      if (this.question.hasAnswerFromCurrentUser) {
        return 'Edit My Answer'
      }

      return 'Answer'
    }
  },
  methods: {
    onAnswerButtonClick() {
      if (this.$root.auth()) {
        $('#question-' + this.question.id + ' .answer.modal')
          .modal({ detachable: false })
          .modal("show")
      }
    },
    onSuggestEditButtonClick() {
      if (this.$root.auth()) {
        if (this.question.hasAnswer) {
          $('#question-' + this.question.id + ' .suggestion.modal')
            .modal({ detachable: false })
            .modal("show")
        }
      }
    },
    onTranslateButtonClick() {
      if (this.$root.auth()) {
        $('#question-' + this.question.id + ' .translation.modal')
          .modal({ detachable: false })
          .modal("show")
      }
    }
  },
  mounted() {
    $('#question-' + this.question.id + ' .more').dropdown()
  }
}
</script>
