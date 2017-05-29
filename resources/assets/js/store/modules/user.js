import _ from 'lodash'
import http from 'lib/http'

const state = {
  hasReadAllNotifications: false,
  unreadNotificationsCount: 0,
  notifications: [],
  languages: []
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
  }
}

const actions = {
  async getNotifications({ commit }) {
    var notifications = await http
      .get('/api/notifications')
      .then(response => response.data)
    commit('concatNotifications', notifications)
    commit('setUnreadNotificationsCount', 0)
  },
  async getOlderNotifications({ commit, state }) {
    var notifications = await http
      .get('/api/notifications?before=' + _.last(state.notifications).id)
      .then(response => response.data)
    commit('concatNotifications', notifications)
  },
  async getNotification({ commit }, id) {
    var notification = await http
      .get('/api/notifications/' + id)
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
}

export default {
  state,
  getters,
  mutations,
  actions
}
