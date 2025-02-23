<template>
  <div id="printorders-admin" class="printorders-container">
    <div class="app-navigation">
      <nav>
        <ul>
          <li :class="{ active: currentView === 'orders' }">
            <a @click="currentView = 'orders'">{{ t('printorders', 'Orders') }}</a>
          </li>
          <li :class="{ active: currentView === 'settings' }">
            <a @click="currentView = 'settings'">{{ t('printorders', 'Settings') }}</a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="app-content">
      <OrderList v-if="currentView === 'orders'" />
      <Settings v-if="currentView === 'settings'" />
    </div>
  </div>
</template>

<script>
import OrderList from './OrderList.vue'
import Settings from './Settings.vue'

export default {
  name: 'AdminApp',
  components: {
    OrderList,
    Settings
  },
  data() {
    return {
      currentView: 'orders'
    }
  }
}
</script>

<style scoped>
.printorders-container {
  width: 100%;
  height: 100%;
  display: flex;
}

.app-navigation {
  width: 250px;
  height: 100%;
  border-right: 1px solid var(--color-border);
}

.app-content {
  flex: 1;
  padding: 20px;
}

.active {
  background-color: var(--color-primary-element-light);
}
</style>