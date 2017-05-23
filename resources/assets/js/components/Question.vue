<template lang='jade'>
  .ui.main.container(v-show='isReady')
    .ui.centered.grid
      .ten.wide.computer.sixteen.wide.mobile.column
        p
          .stat {{ question.answerRequestsCount }} Answer requests

        request-answer-button
        #answerButton.ui.tiny.basic.button(
          @click='openAnswerForm'
          v-if="! question.hasAnswerFromCurrentUser"
        )
          i.edit.icon
          strong Answer
        //- .ui.tiny.basic.button
        //-   i.share.icon
        //-   strong Share
        //- .ui.tiny.basic.icon.button.right.floated
        //-   i.ellipsis.vertical.icon

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
import store from './../store'
import { mapState } from 'vuex'
import { mapActions } from 'vuex'
import RequestAnswerButton from './RequestAnswerButton.vue'
import AnswerCard from './AnswerCard.vue'
import AnswerForm from './AnswerForm.vue'

export default {
  store,
  props: ['id'],
  components: {
    RequestAnswerButton,
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
    }
  },
  methods: {
    ...mapActions([
      'getQuestion'
    ]),
    openAnswerForm() {
      this.isWritingAnswer = true
    }
  },
  mounted() {
    this
      .getQuestion(this.id)
      .then(() => this.isReady = true)
  }
}
</script>
