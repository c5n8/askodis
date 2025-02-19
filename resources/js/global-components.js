import vue from 'vue'
import NotificationMenu from './components/NotificationMenu.vue'
import NotificationPopup from './components/NotificationPopup.vue'
import AccountMenu from './components/AccountMenu.vue'
import Question from './components/Question.vue'
import QuestionList from './components/QuestionList.vue'
import UserQuestionList from './components/UserQuestionList.vue'
import QuestionForm from './components/QuestionForm.vue'
import EditionComparation from './components/EditionComparation.vue'
import EditionTranslation from './components/EditionTranslation.vue'
import AnswerFormModal from './components/AnswerFormModal.vue'

vue.component('user-question-list', UserQuestionList)
vue.component('question-list', QuestionList)
vue.component('question', Question)
vue.component('question-form', QuestionForm)
vue.component('notification-menu', NotificationMenu)
vue.component('notification-popup', NotificationPopup)
vue.component('account-menu', AccountMenu)
vue.component('answer-form-modal', AnswerFormModal)
vue.component('edition-translation', EditionTranslation)
vue.component('edition-comparation', EditionComparation)
