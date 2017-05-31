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
    createVote(state, { votable, payload }) {
      votable.votesCount++
      votable.hasVoteFromCurrentUser = true
      votable.voteFromCurrentUser = payload
    },
    deleteVote(state, { votable }) {
      votable.votesCount--
      votable.hasVoteFromCurrentUser = false
      votable.voteFromCurrentUser = null
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
    async postQuestionVote({ commit, state }) {
      var vote = await http
        .post('/api/questions/' + state.question.id + '/votes')
        .then(response => response.data)
      commit('createVote', { votable: state.question, payload: vote })
    },
    async postAnswerVote({ commit, state }, answer) {
      var vote = await http
        .post('/api/questions/' + state.question.id + '/answers/' + answer.id + '/votes')
        .then(response => response.data)
      commit('createVote', { votable: answer, payload: vote })
    },
    async deleteVote({ commit }, votable) {
      await http.delete('/api/votes/' + votable.voteFromCurrentUser.id)
      commit('deleteVote', { votable: votable })
    },
    async postAnswer({ commit, state }) {
      var answer = await http
        .post('/api/questions/' + state.question.id + '/answers', state.question.answerFromCurrentUser)
        .then(response => response.data)
      commit('addAnswerFromCurrentUser', answer)
    },
    async patchAnswer({ commit, state }, answer) {
      var answer = await http
        .patch('/api/questions/' + state.question.id + '/answers/' + answer.id, answer)
        .then(response => response.data)
      commit('setAnswerFromCurrentUser', answer)
    }
  }
})
