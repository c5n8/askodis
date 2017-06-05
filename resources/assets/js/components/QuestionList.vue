<template lang='jade'>
.ui.main.container
  .ui.centered.grid
    .ten.wide.computer.sixteen.wide.mobile.column
      //- h3  {{ $t('Newest Questions') }}
      .ui.cards
        question-card(
          :question='question'
          v-for='question in questions'
          ':key'='question.id'
        )

        .ui.centered.inline.loader(
          :class='{ active: ! user.hasReadAllQuestions }'
          style='margin-top: 1em; margin-bottom: 1em'
        )
</template>

<script>
import { mapState, mapActions } from 'vuex'
import QuestionCard from 'components/QuestionCard'
import _ from 'lodash'

export default {
  components: {
    QuestionCard
  },
  data() {
    return {
      isLoadingMoreQuestions: false,
    }
  },
  computed: {
    ...mapState([
      'questions',
      'user'
    ])
  },
  methods: {
    ...mapActions([
      'getQuestions',
      'getOlderQuestions'
    ]),
  },
  mounted() {
    this.getQuestions()

    $(window).scroll(_.debounce(event => {
      // if($(window).scrollTop() + $(window).height() == $(document).height())
      if($(window).scrollTop() + $(window).height() > $(document).height() - 100)
      {
        if (this.isLoadingMoreQuestions) {
          return
        }

        this.isLoadingMoreQuestions = true

        this
          .getOlderQuestions()
          .then(() => {
            this.isLoadingMoreQuestions = false
          })
      }
    }, 150));
  }
}
</script>

<style lang='stylus' scoped>
.main.container
  margin-top: 5em;
</style>
