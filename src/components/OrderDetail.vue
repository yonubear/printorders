<template>
  <div class="order-detail" v-if="order">
    <div class="order-header">
      <h2>{{ t('printorders', 'Order Details') }} - {{ order.trackingId }}</h2>
      <div class="order-status">
        <span class="status-label">{{ t('printorders', 'Status:') }}</span>
        <span :class="['status-badge', order.status]">{{ order.status }}</span>
      </div>
    </div>

    <div class="order-info">
      <div class="info-section">
        <h3>{{ t('printorders', 'Customer Information') }}</h3>
        <div class="info-grid">
          <div class="info-item">
            <label>{{ t('printorders', 'Name') }}</label>
            <span>{{ order.customerName }}</span>
          </div>
          <div class="info-item">
            <label>{{ t('printorders', 'Email') }}</label>
            <span>{{ order.email }}</span>
          </div>
          <div class="info-item">
            <label>{{ t('printorders', 'Phone') }}</label>
            <span>{{ order.phone || t('printorders', 'Not provided') }}</span>
          </div>
        </div>
      </div>

      <div class="info-section">
        <h3>{{ t('printorders', 'Order Information') }}</h3>
        <div class="info-grid">
          <div class="info-item">
            <label>{{ t('printorders', 'Created') }}</label>
            <span>{{ formatDate(order.created) }}</span>
          </div>
          <div class="info-item">
            <label>{{ t('printorders', 'Last Updated') }}</label>
            <span>{{ formatDate(order.updated) }}</span>
          </div>
          <div class="info-item">
            <label>{{ t('printorders', 'Total Items') }}</label>
            <span>{{ order.items.length }}</span>
          </div>
        </div>
      </div>

      <div class="photos-section">
        <h3>{{ t('printorders', 'Photos') }}</h3>
        <div class="photos-grid">
          <div v-for="photo in order.photos" :key="photo.path" class="photo-item">
            <img :src="getPhotoUrl(photo.path)" :alt="photo.name">
            <div class="photo-info">
              <span class="photo-name">{{ photo.name }}</span>
              <span class="photo-size">{{ formatFileSize(photo.size) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="order-actions">
      <button @click="previewOrder" class="primary">
        {{ t('printorders', 'Preview PDF') }}
      </button>
      <button @click="downloadOrder">
        {{ t('printorders', 'Download PDF') }}
      </button>
      <button @click="updateStatus" :disabled="updating">
        {{ updating ? t('printorders', 'Updating...') : t('printorders', 'Update Status') }}
      </button>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'
import { useStore } from 'vuex'
import { showSuccess, showError } from '@nextcloud/dialogs'
import api from '../services/api'

export default {
  name: 'OrderDetail',
  props: {
    orderId: {
      type: String,
      required: true
    }
  },
  setup(props) {
    const store = useStore()
    const updating = ref(false)

    const order = computed(() => store.getters.getOrderById(props.orderId))

    const formatDate = (date) => {
      return new Date(date).toLocaleString()
    }

    const formatFileSize = (bytes) => {
      const units = ['B', 'KB', 'MB', 'GB']
      let size = bytes
      let unitIndex = 0
      
      while (size >= 1024 && unitIndex < units.length - 1) {
        size /= 1024
        unitIndex++
      }
      
      return `${size.toFixed(1)} ${units[unitIndex]}`
    }

    const getPhotoUrl = (path) => {
      return OC.generateUrl('/apps/printorders/photos/' + path)
    }

    const previewOrder = () => {
      api.previewOrderPDF(props.orderId)
    }

    const downloadOrder = () => {
      api.downloadOrderPDF(props.orderId)
    }

    const updateStatus = async () => {
      updating.value = true
      try {
        await store.dispatch('updateOrderStatus', {
          orderId: props.orderId,
          status: order.value.status
        })
        showSuccess(t('printorders', 'Order status updated successfully'))
      } catch (error) {
        showError(t('printorders', 'Failed to update order status'))
      } finally {
        updating.value = false
      }
    }

    return {
      order,
      updating,
      formatDate,
      formatFileSize,
      getPhotoUrl,
      previewOrder,
      downloadOrder,
      updateStatus
    }
  }
}
</script>

<style scoped>
.order-detail {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.order-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.status-badge {
  padding: 5px 10px;
  border-radius: 4px;
  text-transform: capitalize;
}

.status-badge.pending {
  background-color: var(--color-warning);
}

.status-badge.processing {
  background-color: var(--color-primary);
}

.status-badge.completed {
  background-color: var(--color-success);
}

.info-section {
  margin-bottom: 30px;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-top: 15px;
}

.info-item label {
  display: block;
  color: var(--color-text-maxcontrast);
  margin-bottom: 5px;
}

.photos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
  margin-top: 15px;
}

.photo-item {
  border: 1px solid var(--color-border);
  border-radius: 4px;
  overflow: hidden;
}

.photo-item img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.photo-info {
  padding: 10px;
}

.photo-name {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.photo-size {
  color: var(--color-text-maxcontrast);
  font-size: 0.9em;
}

.order-actions {
  margin-top: 30px;
  display: flex;
  gap: 10px;
}

button {
  min-width: 120px;
}

button.primary {
  background-color: var(--color-primary);
  color: var(--color-primary-text);
  border: none;
}
</style>