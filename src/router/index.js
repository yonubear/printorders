import { createRouter, createWebHashHistory } from 'vue-router'
import Orders from '../views/Orders.vue'

const routes = [
	{
		path: '/',
		name: 'root',
		redirect: '/orders',
	},
	{
		path: '/orders',
		name: 'orders',
		component: Orders,
	},
]

export default createRouter({
	history: createWebHashHistory(),
	routes,
})