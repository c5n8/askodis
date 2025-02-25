import vue from 'vue'
import NotificationMenu from 'components/NotificationMenu'
import NotificationPopup from 'components/NotificationPopup'
import AccountMenu from 'components/AccountMenu'
import Question from 'components/Question'
import QuestionList from 'components/QuestionList'
import UserQuestionList from 'components/UserQuestionList'
import QuestionForm from 'components/QuestionForm'
import EditionComparation from 'components/EditionComparation'
import EditionTranslation from 'components/EditionTranslation'
import AnswerFormModal from 'components/AnswerFormModal'

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
