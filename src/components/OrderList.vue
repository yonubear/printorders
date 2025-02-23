<template>
  <div class="order-list">
    <div class="controls">
      <div class="search">
        <input 
          type="text" 
          v-model="searchQuery"
          :placeholder="t('printorders', 'Search orders...')"
        >
      </div>
      <div class="actions">
        <button @click="downloadSelected" :disabled="!selectedOrders.length">
          {{ t('printorders', 'Download Selected') }}
        </button>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th><input type="checkbox" v-model="selectAll"></th>
          <th>{{ t('printorders', 'Order ID') }}</th>
          <th>{{ t('printorders', 'Customer') }}</th>
          <th>{{ t('printorders', 'Status') }}</th>
          <th>{{ t('printorders', 'Created') }}</th>
          <th>{{ t('printorders', 'Actions') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in filteredOrders" :key="order.id">
          <td>
            <input 
              type="checkbox" 
              v-model="selectedOrders"
              :value="order.id"
            >
          </td>
          <td>{{ order.trackingId }}</td>
          <td>{{ order.customerName }}</td>
          <td>
            <select v-model="order.status" @change="updateOrderStatus(order)">
              <option value="pending">{{ t('printorders', 'Pending') }}</option>
              <option value="processing">{{ t('printorders', 'Processing') }}</option>
              <option value="completed">{{ t('printorders', 'Completed') }}</option>
              <option value="cancelled">{{ t('printorders', 'Cancelled') }}</option>
            </select>
          </td>
          <td>{{ formatDate(order.created) }}</td>
          <td>
            <button @click="previewOrder(order.id)">
              {{ t('printorders', 'Preview') }}
            </button>
            <button @click="downloadOrder(order.id)">
              {{ t('printorders', 'Download') }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, computed } from 'vue'
import api from '../services/api'

export default {
  name: 'OrderList',
  setup() {
    const orders = ref([])
    const selectedOrders = ref([])
    const searchQuery = ref('')

    const fetchOrders = async () => {
      try {
        orders.value = await api.getOrders()
      } catch (error) {
        console.error('Error fetching orders:', error)
        // Show error notification
      }
    }

    const filteredOrders = computed(() => {
      return orders.value.filter(order => 
        order.trackingId.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        order.customerName.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    })

    const updateOrderStatus = async (order) => {
      try {
        await api.updateOrder(order.id, { status: order.status })
        // Show success notification
      } catch (error) {
        console.error('Error updating order:', error)
        // Show error notification
      }
    }

    const downloadSelected = async () => {
      if (selectedOrders.value.length > 0) {
        await api.downloadBatchPDF(selectedOrders.value)
      }
    }

    // Initial fetch
    fetchOrders()

    return {
      orders,
      selectedOrders,
      searchQuery,
      filteredOrders,
      updateOrderStatus,
      downloadSelected
    }
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleString()
    },
    previewOrder(id) {
      api.previewOrderPDF(id)
    },
    downloadOrder(id) {
      api.downloadOrderPDF(id)
    }
  }
}
</script>

<style scoped>
.order-list {
  width: 100%;
}

.controls {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid var(--color-border);
}

.actions button {
  margin-left: 8px;
}
</style>