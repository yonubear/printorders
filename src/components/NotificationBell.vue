<template>
  <div class="notification-bell">
    <div class="bell-icon" @click="toggleDropdown" ref="bell">
      <span class="icon-bell"></span>
      <span v-if="unreadCount" class="badge">{{ unreadCount }}</span>
    </div>

    <div v-if="showDropdown" class="notifications-dropdown" ref="dropdown">
      <div class="dropdown-header">
        <h3>{{ t('printorders', 'Notifications') }}</h3>
        <button v-if="notifications.length" @click="markAllAsRead">
          {{ t('printorders', 'Mark all as read') }}
        </button>
      </div>

      <div class="notifications-list" v-if="notifications.length">
        <div 
          v-for="notification in notifications" 
          :key="notification.id"
          :class="['notification-item', { unread: !notification.read }]"
          @click="handleNotificationClick(notification)"
        >
          <div class="notification-content">
            <p class="notification-title">{{ notification.title }}</p>
            <p class="notification-message">{{ notification.message }}</p>
            <span class="notification-time">{{ formatTime(notification.time) }}</span>
          </div>
          <button 
            class="mark-read-btn"
            @click.stop="markAsRead(notification.id)"
            v-if="!notification.read"
          >
            <span class="icon-checkmark"></span>
          </button>
        </div>
      </div>

      <div v-else class="no-notifications">
        {{ t('printorders', 'No notifications') }}
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useStore } from 'vuex'
import { formatDistanceToNow } from 'date-fns'

export default {
  name: 'NotificationBell',
  setup() {
    const store = useStore()
    const showDropdown = ref(false)
    const bell = ref(null)
    const dropdown = ref(null)

    const notifications = computed(() => store.state.notifications)
    const unreadCount = computed(() => 
      notifications.value.filter(n => !n.read).length
    )

    const toggleDropdown = () => {
      showDropdown.value = !showDropdown.value
    }

    const handleClickOutside = (event) => {
      if (showDropdown.value && 
          !bell.value.contains(event.target) && 
          !dropdown.value.contains(event.target)) {
        showDropdown.value = false
      }
    }

    const markAsRead = async (notificationId) => {
      await store.dispatch('markNotificationAsRead', notificationId)
    }

    const markAllAsRead = async () => {
      await store.dispatch('markAllNotificationsAsRead')
    }

    const handleNotificationClick = (notification) => {
      if (!notification.read) {
        markAsRead(notification.id)
      }
      // Navigate to relevant page based on notification type
      if (notification.type === 'order') {
        // Navigate to order detail
        router.push(`/orders/${notification.orderId}`)
      }
    }

    const formatTime = (timestamp) => {
      return formatDistanceToNow(new Date(timestamp), { addSuffix: true })
    }

    onMounted(() => {
      document.addEventListener('click', handleClickOutside)
    })

    onUnmounted(() => {
      document.removeEventListener('click', handleClickOutside)
    })

    return {
      showDropdown,
      notifications,
      unreadCount,
      bell,
      dropdown,
      toggleDropdown,
      markAsRead,
      markAllAsRead,
      handleNotificationClick,
      formatTime
    }
  }
}
</script>

<style scoped>
.notification-bell {
  position: relative;
}

.bell-icon {
  cursor: pointer;
  position: relative;
  padding: 8px;
}

.badge {
  position: absolute;
  top: 0;
  right: 0;
  background-color: var(--color-error);
  color: white;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 12px;
}

.notifications-dropdown {
  position: absolute;
  right: 0;
  top: 100%;
  width: 300px;
  background: var(--color-main-background);
  border: 1px solid var(--color-border);
  border-radius: 4px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  z-index: 100;
}

.dropdown-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px;
  border-bottom: 1px solid var(--color-border);
}

.notifications-list {
  max-height: 400px;
  overflow-y: auto;
}

.notification-item {
  display: flex;
  padding: 12px;
  border-bottom: 1px solid var(--color-border);
  cursor: pointer;
}

.notification-item:hover {
  background-color: var(--color-background-hover);
}

.notification-item.unread {
  background-color: var(--color-primary-light);
}

.notification-content {
  flex: 1;
}

.notification-title {
  font-weight: bold;
  margin-bottom: 4px;
}

.notification-message {
  color: var(--