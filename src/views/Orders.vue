<template>
	<NcContent app-name="printorders">
		<NcAppContent>
			<div class="print-orders">
				<NcEmptyContent
					v-if="!hasOrders"
					:title="t('printorders', 'No print orders')"
					:description="t('printorders', 'Create your first print order')"
				>
					<template #icon>
						<Print :size="20" />
					</template>
					<template #action>
						<NcButton
							type="primary"
							@click="createNewOrder"
						>
							{{ t('printorders', 'Create order') }}
						</NcButton>
					</template>
				</NcEmptyContent>

				<div v-else class="orders-list">
					<NcLoadingSpinner v-if="loading" />
					<div v-else>
						<h2>{{ t('printorders', 'Your Print Orders') }}</h2>
						<NcListItem v-for="order in orders"
							:key="order.id"
							:title="order.title"
							:subtitle="order.description">
							<template #actions>
								<NcActionButton
									:aria-label="t('printorders', 'View order')"
									@click="viewOrder(order)">
									<template #icon>
										<Eye :size="20" />
									</template>
								</NcActionButton>
							</template>
						</NcListItem>
					</div>
				</div>
			</div>
		</NcAppContent>
	</NcContent>
</template>

<script>
import {
	NcContent,
	NcAppContent,
	NcEmptyContent,
	NcButton,
	NcLoadingSpinner,
	NcListItem,
	NcActionButton,
} from '@nextcloud/vue'
import { Print, Eye } from '@heroicons/vue/24/outline'
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import { showError } from '@nextcloud/dialogs'

export default {
	name: 'Orders',

	components: {
		NcContent,
		NcAppContent,
		NcEmptyContent,
		NcButton,
		NcLoadingSpinner,
		NcListItem,
		NcActionButton,
		Print,
		Eye,
	},

	data() {
		return {
			loading: true,
			orders: [],
		}
	},

	computed: {
		hasOrders() {
			return this.orders.length > 0
		},
	},

	async mounted() {
		try {
			await this.loadOrders()
		} catch (error) {
			console.error('Error loading orders:', error)
			showError(t('printorders', 'Could not load orders'))
		} finally {
			this.loading = false
		}
	},

	methods: {
		async loadOrders() {
			try {
				const response = await axios.get(generateUrl('/apps/printorders/orders'))
				this.orders = response.data
			} catch (error) {
				console.error('Error fetching orders:', error)
				throw error
			}
		},

		createNewOrder() {
			// TODO: Implement order creation
			console.log('Creating new order')
		},

		viewOrder(order) {
			// TODO: Implement order viewing
			console.log('Viewing order:', order)
		},
	},
}
</script>

<style lang="scss" scoped>
.print-orders {
	padding: 20px;
	height: 100%;
	width: 100%;
	box-sizing: border-box;
}

.orders-list {
	max-width: 800px;
	margin: 0 auto;

	h2 {
		margin-bottom: 20px;
	}
}
</style>