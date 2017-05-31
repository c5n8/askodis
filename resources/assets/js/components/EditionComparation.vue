<template lang='jade'>
.ui.main.container
  .ui.centered.grid
    .ten.wide.computer.sixteen.wide.mobile.column
      h4 Edit suggestion to your answer
      .ui.raised.fluid.card
        .content
          slot(name='user')
          .meta
            a.date(:title=' createdAt | formatDateTime') {{  createdAt | humanizeDateTime }}
          #displayDiff.description
        .extra.content
          template(v-if='status == "pending"')
            button.ui.green.tiny.button(:class='{ disabled: this.isDisabled }' @click='onAcceptButtonClick')
              i.check.icon
              | Accept
            button.ui.red.tiny.right.floated.button(
              :class='{ disabled: this.isDisabled }'
              @click='onRejectButtonClick'
            )
              i.cancel.icon
              | Reject
          .ui.positive.message(v-else-if='status == "accepted"')
            .description(:title=' actionAt | formatDateTime')
              | Accepted {{  actionAt | humanizeDateTime }}
          .ui.negative.message(v-else)
            .description(:title=' actionAt | formatDateTime')
              | Rejected {{  actionAt | humanizeDateTime }}

  div(v-show='false ')
    slot(name='data')
</template>

<script>
import http from 'lib/http'
import moment from 'moment'

const JsDiff = require('diff')

export default {
  props: [
    'id',
    'initStatus',
    'createdAt',
    'updatedAt'
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
        .patch('/api/edits/' + this.id, { status: 'accepted'})
        .then(() => {
          this.isDisabled = false
          this.status = 'accepted'
          this.actionAt = moment()
        })
    },
    onRejectButtonClick() {
      this.isDisabled = true

      http
        .patch('/api/edits/' + this.id, { status: 'rejected'})
        .then(() => {
          this.isDisabled = false
          this.status = 'rejected'
          this.actionAt = moment()
        })
    }
  },
  mounted() {
    var original  = $('#originalEdit').text()
    var suggested = $('#suggestedEdit').text()
    var color     = ''
    var span      = null
    var diff      = JsDiff.diffWords(original, suggested)
    var display   = document.getElementById('displayDiff')
    var fragment  = document.createDocumentFragment()

    diff.forEach(part => {
      color = part.added ? '#99ff99': part.removed ? '#ff8888': 'white'
      span = document.createElement('span')
      span.style.backgroundColor = color

      if (color == '#ff8888') {
        span.style.textDecoration = 'line-through'
      }

      span.appendChild(document.createTextNode(part.value))
      fragment.appendChild(span)
    })

    display.appendChild(fragment)
  }
}
</script>
