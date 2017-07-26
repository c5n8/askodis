import _ from 'lodash'
import http from 'lib/http'

const state = {
  hasReadAllQuestions: false,
  hasReadAllNotifications: false,
  unreadNotificationsCount: 0,
  notifications: [],
  languages: [],
  questions: [],
}

const getters = {
  preferredLanguage: state => {
    return state.languages.find(language => language.isPreferred == true)
  }
}

const mutations = {
  setUnreadNotificationsCount(state, payload) {
    state.unreadNotificationsCount = payload
  },
  incrementUnreadNotificationsCount(state) {
    state.unreadNotificationsCount++
  },
  concatNotifications(state, payload) {
    state.notifications = state.notifications.concat(payload)

    if (payload.length < 10) {
      state.hasReadAllNotifications = true
    }
  },
  unshiftNotifications(state, payload) {
    state.notifications.unshift(payload)
  },
  setLanguages(state, payload) {
    state.languages = payload
  },
  concatUserQuestions(state, payload) {
    state.questions = state.questions.concat(payload)
  },
}

const actions = {
  async getNotifications({ commit }) {
    var notifications = await http
      .get('/api/my/notifications')
      .then(response => response.data)
    commit('concatNotifications', notifications)
    commit('setUnreadNotificationsCount', 0)
  },
  async getOlderNotifications({ commit, state }) {
    var notifications = await http
      .get('/api/my/notifications?before=' + _.last(state.notifications).id)
      .then(response => response.data)
    commit('concatNotifications', notifications)
  },
  async getNotification({ commit }, id) {
    var notification = await http
      .get('/api/my/notifications/' + id)
      .then(response => response.data)
    commit('unshiftNotifications', notification)
  },
  async readNotifications({ commit }) {
    await http.patch('/api/unread_notifications')
  },
  async getUserLanguages({ commit }) {
    var languages = await http.get('/api/my/languages').then((response) => response.data)
    commit('setLanguages', languages)
  },
  async getUserQuestions({ commit }, username) {
    var questions = await http
      .get('/api/users/' + username + '/questions')
      .then(response => response.data)

    commit('concatUserQuestions', questions)
  },
  async getOlderUserQuestions({ commit, state }, username) {
    var questions = await http
      .get('/api/users/' + username + '/questions?before=' + _.last(state.questions).id)
      .then(response => response.data)
    commit('concatQuestions', questions)
  },
}

export default {
  state,
  getters,
  mutations,
  actions
}
