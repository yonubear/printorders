import { createApp } from '@nextcloud/vue'
import { translate as t, translatePlural as n } from '@nextcloud/l10n'
import router from './router'
import App from './App.vue'

// Create app
const app = createApp(App)

// Register router
app.use(router)

// Register translations
app.config.globalProperties.$t = t
app.config.globalProperties.$n = n

// Mount app
app.mount('#app')