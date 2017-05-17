<template lang="jade">
  div(v-show="isReady")
    request-answer-button
    p
      small.stat {{ question.answerRequestsCount }} Answer requests
</template>

<script>
import store from './../store'
import { mapState } from 'vuex'
import { mapActions } from 'vuex'
import RequestAnswerButton from './RequestAnswerButton.vue'

export default {
  store,
  data() {
    return {
      isReady: false
    }
  },
  props: ['id'],
  components: {
    RequestAnswerButton
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
