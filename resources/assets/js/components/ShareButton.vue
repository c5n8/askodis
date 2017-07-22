<template lang='jade'>
.share.ui.top.left.pointing.dropdown.tiny.basic.button
  i.icon(:class='{ group: message, share: ! message}' )
  strong {{ message ? message : $t('Share')}}
  .menu
    a.item(
      :href='"https://www.facebook.com/sharer/sharer.php?u=" + shareUrl'
      target='_blank'
    )
      i.facebook.icon
      | Facebook
    a.item(
      :href='"https://twitter.com/intent/tweet?url=" + shareUrl'
      target='_blank'
    )
      i.twitter.icon
      | Twitter
    a.item(
      :href='"https://plus.google.com/share?url=" + shareUrl'
      target='_blank'
    )
      i.google.icon
      | Google+
</template>

<script>
export default {
  props: ['shareUrl', 'message'],
  mounted() {
    $('.share.button').dropdown()
  }
}
</script>
