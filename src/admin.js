import { createApp } from 'vue'
import { createRouter } from './router'
import { createStore } from './store'
import i18n from './l10n'
import AdminApp from './components/AdminApp.vue'
import ErrorBoundary from './components/ErrorBoundary.vue'
import LoadingSpinner from './components/LoadingSpinner.vue'
import '@nextcloud/dialogs/styles/toast.scss'
import '../css/admin.css'

const app = createApp(AdminApp)

// Register global components
app.component('ErrorBoundary', ErrorBoundary)
app.component('LoadingSpinner', LoadingSpinner)

// Use plugins
app.use(createRouter())
app.use(createStore())
app.use(i18n)

// Error handling
app.config.errorHandler = (err, vm, info) => {
  console.error('Global error:', err)
  console.error('Component:', vm)
  console.error('Info:', info)
}

// Mount app
app.mount('#printorders-admin')