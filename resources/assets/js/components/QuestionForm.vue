<template lang='jade'>
  #questionForm.ui.small.modal
    i.close.icon
    .content
      .ui.form
        .field
          label Question
          input(type='text' placeholder='Write your question' ':value'='body')
        .ui.green.tiny.button
          i.send.icon
          | Post Questionq
</template>

<script>
export default {
  props: ['body']
}
</script>
