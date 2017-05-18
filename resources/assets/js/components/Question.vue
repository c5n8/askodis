<template lang='jade'>
  .ui.main.container(v-show='isReady')
    .ui.centered.grid
      .ten.wide.column
        request-answer-button
        p
          .stat {{ question.answerRequestsCount }} Answer requests
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
  data() {
    return {
      isReady: false
    }
  },
  props: ['id'],
  components: {
    RequestAnswerButton,
    AnswerList
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
