<template lang='jade'>
  .ui.main.container(v-if='isReady')
    .ui.centered.grid
      .ten.wide.computer.sixteen.wide.mobile.column
        p
          .stat {{ question.votesCount }} People ask

        ask-button
        button.ui.tiny.basic.button(@click='onAnswerButtonClick')
          i.edit.icon
          strong {{ answerButtonText }}

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

        .ui.cards
          answer-card(
            :answer='answer'
            v-for='answer in question.answers'
            ':key'='answer.id'
          )
</template>

<script>
import { mapState, mapActions } from 'vuex'
import store from 'store'
import AskButton from 'components/AskButton'
import AnswerCard from 'components/AnswerCard'
import AnswerForm from 'components/AnswerForm'

export default {
  store,
  props: ['id'],
  components: {
    AskButton,
    AnswerCard,
    AnswerForm
  },
  data() {
    return {
      isReady: false,
      isWritingAnswer: false
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
    },
  },
  methods: {
    ...mapActions([
      'getQuestion'
    ]),
    onAnswerButtonClick() {
      this.isWritingAnswer = true
    },
  },
  mounted() {
    this
      .getQuestion(this.id)
      .then(() => this.isReady = true)
  }
}
</script>
