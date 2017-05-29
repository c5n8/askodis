import vue from 'vue'
import vuex from 'vuex'
import _ from 'lodash'
import http from 'lib/http'
import clock from 'store/modules/clock'
import user from 'store/modules/user'

vue.use(vuex)

export default new vuex.Store({
  modules: {
    clock,
    user
  },
  state: {
    query: '',
    question: {}
  },
  mutations: {
    setQuery(state, payload) {
      state.query = payload
    },
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
    setAnswerFromCurrentUser(state, payload) {
      state.question.answerFromCurrentUser = payload

      var currentUserAnswerIndex = _.findIndex(state.question.answers, answer => answer.id == payload.id)
      state.question.answers[currentUserAnswerIndex] = payload
    }
  },
  actions: {
    async getQuestion({ commit }, id) {
      var question = await http
        .get('/api/questions/' + id)
        .then(response => response.data)
      commit('setQuestion', question)
    },
    async postAnswerRequest({ commit, state }) {
      await http.post('/api/questions/' + state.question.id + '/answer_requests')
      commit('startRequestingAnswer')
    },
    async deleteAnswerRequest({ commit, state }) {
      await http.delete('/api/questions/' + state.question.id + '/answer_requests')
      commit('stopRequestingAnswer')
    },
    async postAnswerVote({ commit }, answer) {
      await http.post('/api/answers/' + answer.id + '/votes')
      commit('voteAnswer', { answer: answer })
    },
    async deleteAnswerVote({ commit }, answer) {
      await http.delete('/api/answers/' + answer.id + '/votes')
      commit('unvoteAnswer', { answer: answer  })
    },
    async postAnswer({ commit, state }) {
      var answer = await http
        .post('/api/questions/' + state.question.id + '/answers', state.question.answerFromCurrentUser)
        .then(response => response.data)
      commit('addAnswerFromCurrentUser', answer)
    },
    async patchAnswer({ commit, state }) {
      var answer = await http
        .patch('/api/questions/' + state.question.id + '/answers', state.question.answerFromCurrentUser)
        .then(response => response.data)
      commit('setAnswerFromCurrentUser', answer)
    }
  }
})
