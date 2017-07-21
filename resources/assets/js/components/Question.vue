<template lang='pug'>
.ui.main.container(v-show='isReady')
  .ui.centered.grid
    .ten.wide.computer.sixteen.wide.mobile.column
      p
        .stat {{ $tc('People ask', question.votesCount) }}

      #questionMenu
        ask-button(:question='question')
        button.ui.tiny.basic.button(@click='onAnswerButtonClick')
          i.edit.icon
          strong {{ $t(answerButtonText) }}
        share-button(:shareUrl='question.shareUrl')
        button.more.ui.icon.top.left.pointing.dropdown.tiny.basic.right.floated.button
          i.vertical.ellipsis.icon
          .menu
            .translate.item(@click='onTranslateButtonClick')
              i.translate.icon
              | {{ $t('Translate') }}

      template(v-if='question.hasAnswerFromCurrentUser && ! isWritingAnswer')
        h4 Your Answer
        answer-card(:answer='question.answerFromCurrentUser')

      template(v-if='isWritingAnswer')
        .ui.hidden.divider
        answer-form(
          ':is-writing-answer'='isWritingAnswer'
          @finishWritingAnswer='isWritingAnswer = false'
        )

      .ui.divider

      h4 {{ answersCountMessage }}

      #answerList.ui.cards
        answer-card(
          :answer='answer'
          v-for='answer in question.answers'
          ':key'='answer.id'
        )

        .ui.centered.inline.loader(
          :class='{ active: isLoadingMoreAnswers }'
          style='margin-top: 2em; margin-bottom: 2em'
        )
  question-translation-form
</template>

<script>
import { mapState, mapActions } from 'vuex'
import store from 'store'
import AskButton from 'components/AskButton'
import ShareButton from 'components/ShareButton'
import AnswerCard from 'components/AnswerCard'
import AnswerForm from 'components/AnswerForm'
import QuestionTranslationForm from 'components/QuestionTranslationForm'

export default {
  store,
  props: ['id'],
  components: {
    ShareButton,
    AskButton,
    AnswerCard,
    QuestionTranslationForm,
    AnswerForm
  },
  data() {
    return {
      isReady: false,
      isWritingAnswer: false,
      isLoadingMoreAnswers: true
    }
  },
  computed: {
    ...mapState([
      'question'
    ]),
    answersCountMessage() {
      var message = this.question.answersCount + ' Answers'

      if (this.question.hasAnswerFromCurrentUser) {
        message = 'All ' + message
      }

      return message
    },
    answerButtonText() {
      if (this.question.hasAnswerFromCurrentUser) {
        return 'Edit My Answer'
      }

      return 'Answer'
    }
  },
  methods: {
    ...mapActions([
      'getQuestion',
      'getMoreAnswers'
    ]),
    onAnswerButtonClick() {
      if (this.$root.auth()) {
        this.isWritingAnswer = true
      }
    },
    onTranslateButtonClick() {
      if (this.$root.auth()) {
        $('#questionTranslationForm')
          .modal({ detachable: false })
          .modal('show')
      }
    }
  },
  watch: {
    isReady() {
      if (this.isReady) {
        var vm = this

        $('#answerList').visibility({
          once: false,
          observeChanges: true,
          onBottomVisible() {
            vm
            .getMoreAnswers()
            .then(() => {
              if (vm.question.answersCount <= vm.question.answers.length) {
                vm.isLoadingMoreAnswers = false
              }
            })
          }
        })
      }
    }
  },
  mounted() {
    this
      .getQuestion(this.id)
      .then(() => {
        if (this.question.answersCount <= this.question.answers.length) {
          this.isLoadingMoreAnswers = false
        }

        this.isReady = true
      })

    $('#questionMenu .more').dropdown()
  }
}
</script>
