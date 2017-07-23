<template lang='jade'>
.ui.main.container
  .ui.centered.grid
    .ten.wide.computer.sixteen.wide.mobile.column
      h4 {{ $t('Translation suggestion to your answer') }}
      .ui.raised.fluid.card
        .content
          slot(name='user')
          .meta
            a.date(:title=' createdAt | formatDateTime') {{  createdAt | humanizeDateTime }}
          .ui.horizontal.divider
          strong {{ originalLanguage }}
          slot(name='original')
          .ui.divider
          strong {{ translationLanguage }}
          slot(name='translation')
        .extra.content
          template(v-if='status == "pending"')
            button.ui.green.tiny.button(:class='{ disabled: this.isDisabled }' @click='onAcceptButtonClick')
              i.check.icon
              | {{ $t('Accept') }}
            button.ui.red.tiny.right.floated.button(
              :class='{ disabled: this.isDisabled }'
              @click='onRejectButtonClick'
            )
              i.cancel.icon
              | {{ $t('Reject') }}
          .ui.positive.message(v-else-if='status == "accepted"')
            .description(:title=' actionAt | formatDateTime')
              | {{ $t('Accepted') }} {{  actionAt | humanizeDateTime }}
          .ui.negative.message(v-else)
            .description(:title=' actionAt | formatDateTime')
              | {{ $t('Rejected') }} {{  actionAt | humanizeDateTime }}

  div(v-show='false ')
    slot(name='data')
</template>

<script>
import http from 'lib/http'
import moment from 'moment'

export default {
  props: [
    'id',
    'initStatus',
    'createdAt',
    'updatedAt',
    'originalLanguage',
    'translationLanguage',
  ],
  data() {
    return {
      status: this.initStatus,
      isDisabled: false,
      actionAt: this.updatedAt
    }
  },
  methods: {
    onAcceptButtonClick() {
      this.isDisabled = true

      http
        .patch('/api/editions/' + this.id, { status: 'accepted'})
        .then(() => {
          this.isDisabled = false
          this.status = 'accepted'
          this.actionAt = moment()
        })
    },
    onRejectButtonClick() {
      this.isDisabled = true

      http
        .patch('/api/editions/' + this.id, { status: 'rejected'})
        .then(() => {
          this.isDisabled = false
          this.status = 'rejected'
          this.actionAt = moment()
        })
    }
  },
}
</script>
