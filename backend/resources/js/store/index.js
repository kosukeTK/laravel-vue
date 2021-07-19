
import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'

export default createStore({
  state: {
    // count: 0,
    loginState: false,
    loginId: '',
    loginName: '',
    photoPath: '',
  },
  mutations: {
    // increment(state){
    //   state.count += 1
    // },
    // decrement(state){
    //   state.count -= 1
    // },
    loginInfo(state, payload) {
      state.loginState  = payload.loginState;
      state.loginId     = payload.loginId;
      state.loginName   = payload.loginName;
      state.photoPath   = payload.photoPath;
    }
  },
  actions: {
    // increment({ commit }) {
    //   commit('increment')
    // }
    // loginInfo() {
    //   commit(loginInfo, payload);
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
        'loginName',
        'photoPath'
      ],
      storage: window.sessionStorage
    }
  )]
})
