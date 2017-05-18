<template lang='jade'>
  .ui.main.container(v-show='isReady')
    .ui.centered.grid
      .ten.wide.computer.sixteen.wide.mobile.column
        p
          .stat {{ question.answerRequestsCount }} Answer requests
        request-answer-button
        .ui.divider
        h4 {{ question.answersCount }} Answers
        answer-list
</template>

<script>
import store from './../store'
import { mapState } from 'vuex'
import { mapActions } from 'vuex'
import RequestAnswerButton from './RequestAnswerButton.vue'
import AnswerList from './AnswerList.vue'

export default {
  store,
  props: ['id'],
  components: {
    RequestAnswerButton,
    AnswerList
  },
  data() {
    return {
      isReady: false
    }
  },
  computed: {
    ...mapState([
      'question'
    ])
  },
  methods: {
    ...mapActions([
      'getQuestion'
    ]),
  },
  mounted() {
    this
      .getQuestion(this.id)
      .then(() => this.isReady = true)
  }
}
</script>
