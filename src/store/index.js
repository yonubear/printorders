import { createStore } from 'vuex'
import api from '../services/api'

export default createStore({
  state: {
    orders: [],
    loading: false,
    error: null,
    currentUser: OC.getCurrentUser().uid,
    settings: null
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
    },
    UPDATE_ORDER(state, updatedOrder) {
      const index = state.orders.findIndex(order => order.id === updatedOrder.id)
      if (index !== -1) {
        state.orders.splice(index, 1, updatedOrder)
      }
    },
    SET_SETTINGS(state, settings) {
      state.settings = settings
    }
  },
  
  actions: {
    async fetchOrders({ commit }) {
      commit('SET_LOADING', true)
      try {
        const orders = await api.getOrders()
        commit('SET_ORDERS', orders)
      } catch (error) {
        commit('SET_ERROR', error.message)
      } finally {
        commit('SET_LOADING', false)
      }
    },
    
    async updateOrderStatus({ commit }, { orderId, status }) {
      try {
        const updatedOrder = await api.updateOrder(orderId, { status })
        commit('UPDATE_ORDER', updatedOrder)
        return true
      } catch (error) {
        commit('SET_ERROR', error.message)
        return false
      }
    }
  },
  
  getters: {
    getOrderById: (state) => (id) => {
      return state.orders.find(order => order.id === id)
    },
    pendingOrders: (state) => {
      return state.orders.filter(order => order.status === 'pending')
    },
    processingOrders: (state) => {
      return state.orders.filter(order => order.status === 'processing')
    }
  }
})