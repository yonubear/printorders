<template>
	<div id="content" class="print-orders-app">
		<NcAppNavigation>
			<template #list>
				<NcAppNavigationItem
					id="all-orders"
					:exact="true"
					:name="t('printorders', 'All Orders')"
					icon="icon-category-monitoring"
					to="/"
				/>
			</template>

			<template #footer>
				<NcAppNavigationSettings>
					<NcSettingsSection :title="t('printorders', 'Print Orders Settings')">
						<!-- Add settings here -->
					</NcSettingsSection>
				</NcAppNavigationSettings>
			</template>
		</NcAppNavigation>

		<router-view />
	</div>
</template>

<script>
import {
	NcAppNavigation,
	NcAppNavigationItem,
	NcAppNavigationSettings,
	NcSettingsSection,
} from '@nextcloud/vue'

export default {
	name: 'App',

	components: {
		NcAppNavigation,
		NcAppNavigationItem,
		NcAppNavigationSettings,
		NcSettingsSection,
	},
}
</script>

<style lang="scss" scoped>
.print-orders-app {
	display: flex;
	width: 100%;
	height: 100%;
	box-sizing: border-box;
}
</style>