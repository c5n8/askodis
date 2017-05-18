import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    question: {},
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
    setAnswerFromCurrentUserBody(state, payload) {
      if (! state.question.hasAnswerFromCurrentUser) {
        state.question.answerFromCurrentUser = {}
      }

      state.question.answerFromCurrentUser.body = payload
    },
    addAnswerFromCurrentUser(state, payload) {
      state.question.hasAnswerFromCurrentUser = true
      state.question.answerFromCurrentUser = payload
      state.question.answers.push(payload)
      state.question.answersCount++
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
    postAnswerVote({ commit, getters }, answer) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/answers/' + answer.id + '/votes')
          .then(response => {
            commit('voteAnswer', { answer: answer })
            resolve()
          })
      })
    },
    deleteAnswerVote({ commit, getters }, answer) {
      return new Promise((resolve, reject) => {
        axios
          .delete('/api/answers/' + answer.id + '/votes')
          .then(response => {
            commit('unvoteAnswer', { answer: answer  })
            resolve()
          })
      })
    },
    postAnswer({ commit, state }) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/questions/' + state.question.id + '/answers', state.question.answerFromCurrentUser)
          .then(response => {
            commit('addAnswerFromCurrentUser', response.data)
            resolve()
          })
      })
    },
  }
})
