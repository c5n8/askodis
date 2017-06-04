<template lang='jade'>
.ui.main.container
  .ui.centered.grid
    .ten.wide.computer.sixteen.wide.mobile.column
      h3  {{ $t('Newest Questions') }}
      .ui.cards
        question-card(
          :question='question'
          v-for='question in questions'
          ':key'='question.id'
        )
</template>

<script>
import { mapState, mapActions } from 'vuex'
import QuestionCard from 'components/QuestionCard'

export default {
  components: {
    QuestionCard
  },
  computed: {
    ...mapState([
      'questions'
    ])
  },
  methods: {
    ...mapActions([
      'getQuestions'
    ])
  },
  mounted() {
    this.getQuestions()
  }
}
</script>

<style lang='stylus' scoped>
.main.container
  margin-top: 5em;
</style>
