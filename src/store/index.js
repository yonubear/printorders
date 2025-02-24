import { createStore } from 'vuex'

export default createStore({
  state: {
    // Your initial state here
    orders: [],
    loading: false,
    error: null
  },
  mutations: {
    SET_ORDERS(state, orders) {
      state.orders = orders
    },
    SET_LOADING(state, status) {
      state.loading = status
    },
    SET_ERROR(state, error) {
      state.error = error
    }
  },
  actions: {
    async fetchOrders({ commit }) {
      try {
        commit('SET_LOADING', true)
        // Add your API call here
        // const response = await axios.get('your-api-endpoint')
        // commit('SET_ORDERS', response.data)
      } catch (error) {
        commit('SET_ERROR', error.message)
      } finally {
        commit('SET_LOADING', false)
      }
    }
  },
  getters: {
    getOrders: state => state.orders,
    isLoading: state => state.loading,
    hasError: state => state.error
  }
})