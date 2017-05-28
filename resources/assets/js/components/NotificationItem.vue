<template lang='jade'>
a.item(':href'='notification.data.action')
  .content
    .description
      span {{ notification.data.message }}
      span {{ '. ' }}
      span.right.floated.stat(:title='notification.createdAt | formatDateTime')
        | {{ notification.createdAt | humanizeDateTime }}
</template>

<script>
export default {
  props: ['notification']
}
</script>
