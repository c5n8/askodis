import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    question: {
      answerRequestsCount: 0
    }
  },
  mutations: {
    setQuestion(state, payload) {
      state.question = payload
    },
    startRequestingAnswer(state) {
      state.question.answerRequestsCount++
      state.question.hasAnswerRequestFromCurrentUser = true
    },
    stopRequestingAnswer(state) {
      state.question.answerRequestsCount--
      state.question.hasAnswerRequestFromCurrentUser = false
    },
  },
  actions: {
    getQuestion({ commit }, id) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/questions/' + id)
          .then(response => {
            commit('setQuestion', response.data)
            resolve()
          })
      })
    },
    postAnswerRequest({ commit, state }) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/questions/' + state.question.id + '/answer_requests')
          .then(response => {
            commit('startRequestingAnswer')
            resolve()
          })
      })
    },
    deleteAnswerRequest({ commit, state }) {
      return new Promise((resolve, reject) => {
        axios
          .delete('/api/questions/' + state.question.id + '/answer_requests')
          .then(response => {
            commit('stopRequestingAnswer')
            resolve()
          })
      })
    }
  }
})
