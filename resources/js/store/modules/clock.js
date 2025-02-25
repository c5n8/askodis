import moment from 'moment'

const state = {
  time: moment(),
  interval: null
}

const mutations = {
  setTime(state, payload) {
    state.time = payload
  },
  setInterval(state, payload) {
    state.interval = payload
  }
}

const actions = {
  startClock({ commit }) {
    commit('setInterval', setInterval(() => commit('setTime', moment()), 60 * 1000))
  },
  stopClock({ commit}) {
    commit('setInterval', clearInterval(state.interval))
  }
}

export default {
  state,
  mutations,
  actions
}
