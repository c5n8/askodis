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
    question: {},
    questions: []
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
    setAnswerFromCurrentUserBody(state, { question, body }) {
      if (! question.hasAnswerFromCurrentUser) {
        question.answerFromCurrentUser = {}
      }

      question.answerFromCurrentUser.body = body
    },
    addAnswerFromCurrentUser(state, { question, answer }) {
      question.hasAnswerFromCurrentUser = true
      question.answerFromCurrentUser = answer

      if (question.hasOwnProperty('topAnswer')) {
        question.topAnswer = answer
      } else {
        question.answers.push(answer)
      }

      question.answersCount++
    },
    setAnswerFromCurrentUser(state, { question, answer}) {
      question.answerFromCurrentUser = answer

      if (question.hasOwnProperty('topAnswer')) {
        question.topAnswer = answer
      } else {
        var currentUserAnswerIndex = _.findIndex(question.answers, answer => answer.id == answer.id)
        question.answers[currentUserAnswerIndex] = answer
      }
    },
    concatAnswers(state, payload) {
      state.question.answers = state.question.answers.concat(payload)
    },
    concatQuestions(state, payload) {
      state.questions = state.questions.concat(payload)

      if (payload.length < 10) {
        state.user.hasReadAllQuestions = true
      }
    },
  },
  actions: {
    async getQuestion({ commit }, id) {
      var question = await http
        .get('/api/questions/' + id)
        .then(response => response.data)
      commit('setQuestion', question)
    },
    async postQuestionVote({ commit, state }, question) {
      var vote = await http
        .post('/api/questions/' + question.id + '/votes')
        .then(response => response.data)
      commit('createVote', { votable: question, payload: vote })
    },
    async postQuestionAnswerVote({ commit }, { question, answer }) {
      var vote = await http
        .post('/api/questions/' + question.id + '/answers/' + answer.id + '/votes')
        .then(response => response.data)
      commit('createVote', { votable: answer, payload: vote })
    },
    async deleteVote({ commit }, votable) {
      await http.delete('/api/votes/' + votable.voteFromCurrentUser.id)
      commit('deleteVote', { votable: votable })
    },
    async postQuestionAnswer({ commit }, question) {
      var answer = await http
        .post('/api/questions/' + question.id + '/answers', question.answerFromCurrentUser)
        .then(response => response.data)
      commit('addAnswerFromCurrentUser', { question: question, answer: answer })
    },
    async patchQuestionAnswer({ commit }, { question, answer }) {
      var answer = await http
        .patch('/api/questions/' + question.id + '/answers/' + answer.id, answer)
        .then(response => response.data)
      commit('setAnswerFromCurrentUser', { question: question, answer: answer })
    },
    async getMoreAnswers({ commit, state}) {
      var answers = await http
        .get('/api/questions/' + state.question.id + '/answers', {
          params: {
            loadedAnswers: _.map(state.question.answers, 'id')
          }
        })
        .then(response => response.data)
      commit('concatAnswers', answers)
    },
    async getQuestions({ commit }) {
      var questions = await http
        .get('/api/questions')
        .then(response => response.data)

      commit('concatQuestions', questions)
    },
    async getOlderQuestions({ commit, state }) {
      var questions = await http
        .get('/api/questions?before=' + _.last(state.questions).id)
        .then(response => response.data)
      commit('concatQuestions', questions)
    },
  }
})
