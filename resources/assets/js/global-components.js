import vue from 'vue'
import NotificationMenu from 'components/NotificationMenu'
import NotificationPopup from 'components/NotificationPopup'
import AccountMenu from 'components/AccountMenu'
import Question from 'components/Question'
import QuestionList from 'components/QuestionList'
import QuestionForm from 'components/QuestionForm'
import EditionComparation from 'components/EditionComparation'

vue.component('question-list', QuestionList)
vue.component('question', Question)
vue.component('question-form', QuestionForm)
vue.component('notification-menu', NotificationMenu)
vue.component('notification-popup', NotificationPopup)
vue.component('account-menu', AccountMenu)
vue.component('edition-comparation', EditionComparation)
