import { createApp } from 'vue'
import AdminApp from './components/AdminApp.vue'
import { createStore } from './store'
import '../css/admin.css'

// Create Vue app
const app = createApp(AdminApp)

// Create and use Vuex store
const store = createStore()
app.use(store)

// Mount app
app.mount('#printorders-admin')