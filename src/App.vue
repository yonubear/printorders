<template>
  <div id="app">
    <h1>Print Orders</h1>
    <div v-if="isLoading">Loading...</div>
    <div v-else-if="hasError">{{ error }}</div>
    <div v-else>
      <!-- Your orders list here -->
      <ul>
        <li v-for="order in orders" :key="order.id">
          {{ order.name }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'App',
  computed: {
    ...mapGetters([
      'getOrders',
      'isLoading',
      'hasError'
    ]),
    orders() {
      return this.getOrders
    }
  },
  methods: {
    ...mapActions([
      'fetchOrders'
    ])
  },
  mounted() {
    this.fetchOrders()
  }
}
</script>

<style>
#app {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  padding: 20px;
}
</style>