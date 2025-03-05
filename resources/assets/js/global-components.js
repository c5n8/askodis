import Vue from 'vue'
import UserQuestionList from './components/UserQuestionList.vue'
import QuestionList from './components/QuestionList.vue'
import Question from './components/Question.vue'
import QuestionForm from './components/QuestionForm.vue'
import NotificationMenu from './components/NotificationMenu.vue'
import NotificationPopup from './components/NotificationPopup.vue'
import AccountMenu from './components/AccountMenu.vue'
import AnswerFormModal from './components/AnswerFormModal.vue'
import EditionTranslation from './components/EditionTranslation.vue'
import EditionComparation from './components/EditionComparation.vue'

Vue.component('user-question-list', UserQuestionList)
Vue.component('question-list', QuestionList)
Vue.component('question', Question)
Vue.component('question-form', QuestionForm)
Vue.component('notification-menu', NotificationMenu)
Vue.component('notification-popup', NotificationPopup)
Vue.component('account-menu', AccountMenu)
Vue.component('answer-form-modal', AnswerFormModal)
Vue.component('edition-translation', EditionTranslation)
Vue.component('edition-comparation', EditionComparation)
