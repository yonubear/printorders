import { createRouter, createWebHistory } from 'vue-router'
import OrderList from '../components/OrderList.vue'
import OrderDetail from '../components/OrderDetail.vue'
import Settings from '../components/Settings.vue'

const routes = [
  {
    path: '/',
    redirect: '/orders'
  },
  {
    path: '/orders',
    name: 'orders',
    component: OrderList
  },
  {
    path: '/orders/:id',
    name: 'order-detail',
    component: OrderDetail,
    props: true
  },
  {
    path: '/settings',
    name: 'settings',
    component: Settings
  }
]

export default createRouter({
  history: createWebHistory(OC.generateUrl('/apps/printorders')),
  routes
})