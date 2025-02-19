<template lang="pug">
.ui.main.container
  .ui.grid
    .three.wide.computer.sixteen.wide.mobile.column
      .ui.raised.card
        .content
          .header Askodis
          .description {{ $t('Ask, answer, collaborate, translate, and more.') }}

      .ui.raised.card
        .content
          .description {{ $t('Askodis is more fun with your friend!') }}
          share-button(':shareUrl'='"https%3A%2F%2Faskodis.com"' ':message'='$t("Invite Friend")')

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
import QuestionCard from './QuestionCard.vue'
import ShareButton from './ShareButton.vue'
import _ from 'lodash'

export default {
  components: {
    ShareButton,
    QuestionCard,
  },
  data() {
    return {
      isLoadingMoreQuestions: false,
    }
  },
  computed: {
    ...mapState(['questions', 'user']),
  },
  methods: {
    ...mapActions(['getQuestions', 'getOlderQuestions']),
  },
  mounted() {
    this.getQuestions()

    $(window).scroll(
      _.debounce((event) => {
        // if($(window).scrollTop() + $(window).height() == $(document).height())
        if (
          $(window).scrollTop() + $(window).height() >
          $(document).height() - 100
        ) {
          if (this.isLoadingMoreQuestions) {
            return
          }

          this.isLoadingMoreQuestions = true

          this.getOlderQuestions().then(() => {
            this.isLoadingMoreQuestions = false
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
