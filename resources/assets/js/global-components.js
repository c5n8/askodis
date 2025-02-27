import Vue from 'vue'

Vue.component(
  'user-question-list',
  () => import('./components/UserQuestionList.vue'),
)
Vue.component('question-list', () => import('./components/QuestionList.vue'))
Vue.component('question', () => import('./components/Question.vue'))
Vue.component('question-form', () => import('./components/QuestionForm.vue'))
Vue.component(
  'notification-menu',
  () => import('./components/NotificationMenu.vue'),
)
Vue.component(
  'notification-popup',
  () => import('./components/NotificationPopup.vue'),
)
Vue.component('account-menu', () => import('./components/AccountMenu.vue'))
Vue.component(
  'answer-form-modal',
  () => import('./components/AnswerFormModal.vue'),
)
Vue.component(
  'edition-translation',
  () => import('./components/EditionTranslation.vue'),
)
Vue.component(
  'edition-comparation',
  () => import('./components/EditionComparation.vue'),
)
