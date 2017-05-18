import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    question: {
      answerRequestsCount: 0
    }
  },
  getters: {
    getAnswerById: (state, getters) => (id) => {
      return state.question.answers.find(answer => answer.id === id)
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
    voteAnswer(state, { answer }) {
      answer.votesCount++
      answer.hasVoteFromCurrentUser = true
    },
    unvoteAnswer(state, { answer }) {
      answer.votesCount--
      answer.hasVoteFromCurrentUser = false
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
    },
    postAnswerVote({ commit, getters }, id) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/answers/' + id + '/votes')
          .then(response => {
            commit('voteAnswer', { answer: getters.getAnswerById(id)  })
            resolve()
          })
      })
    },
    deleteAnswerVote({ commit, getters }, id) {
      return new Promise((resolve, reject) => {
        axios
          .delete('/api/answers/' + id + '/votes')
          .then(response => {
            commit('unvoteAnswer', { answer: getters.getAnswerById(id)  })
            resolve()
          })
      })
    },
  }
})
