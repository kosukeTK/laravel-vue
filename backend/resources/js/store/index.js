
import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'

export default createStore({
  state: {
    // count: 0,
    loginState: false,
    loginId: '',
    loginName: ''
  },
  mutations: {
    // increment(state){
    //   state.count += 1
    // },
    // decrement(state){
    //   state.count -= 1
    // },
    loginInfo(state, payload) {
      state.loginState  = payload.loginState
      state.loginId     = payload.loginId
      state.loginName   = payload.loginName
    }
  },
  actions: {
    // increment({ commit }) {
    //   commit('increment')
    // }      
  },
  getters: {
    getLoginInfo: state => {
      return state
    }
  },
  modules: {

  },
  plugins: [createPersistedState(
    {
      key: 'loginStates',
      paths: [
        'loginState',
        'loginId',
        'loginName'
      ],
      storage: window.sessionStorage
    }
  )]
})
