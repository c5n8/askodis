<template lang="pug">
.ui.main.container
  .ui.grid
    .three.wide.computer.sixteen.wide.mobile.column

    .ten.wide.computer.sixteen.wide.mobile.column
      //- h3  {{ $t('Newest Questions') }}
      .ui.cards
        question-card(
          :question='question'
          v-for='question in user.questions'
          ':key'='question.id'
        )

        .ui.centered.inline.loader(
          :class='{ active: ! user.hasReadAllQuestions }'
          style='margin-top: 1em; margin-bottom: 1em'
        )
</template>

<script>
import { mapState, mapActions } from 'vuex'
import QuestionCard from './QuestionCard.vue'
import ShareButton from './ShareButton.vue'
import _ from 'lodash'

export default {
  components: {
    ShareButton,
    QuestionCard,
  },
  props: ['username'],
  data() {
    return {
      isLoadingMoreUserQuestions: false,
    }
  },
  computed: {
    ...mapState(['questions', 'user']),
  },
  methods: {
    ...mapActions(['getUserQuestions', 'getOlderUserQuestions']),
  },
  mounted() {
    this.getUserQuestions(this.username)

    $(window).scroll(
      _.debounce((event) => {
        // if($(window).scrollTop() + $(window).height() == $(document).height())
        if (
          $(window).scrollTop() + $(window).height() >
          $(document).height() - 100
        ) {
          if (this.isLoadingMoreUserQuestions) {
            return
          }

          this.isLoadingMoreUserQuestions = true

          this.getOlderUserQuestions(this.username).then(() => {
            this.isLoadingMoreUserQuestions = false
          })
        }
      }, 150),
    )
  },
}
</script>

<style lang="stylus" scoped>
.main.container
  margin-top: 5em;
</style>
