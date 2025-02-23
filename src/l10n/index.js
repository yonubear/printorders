import { getLanguage } from '@nextcloud/l10n'
import { createI18n } from 'vue-i18n'

const messages = {
  en: {
    printorders: {
      'Orders': 'Orders',
      'Settings': 'Settings',
      'Status': 'Status',
      'Customer': 'Customer',
      'Created': 'Created',
      'Actions': 'Actions',
      'Preview': 'Preview',
      'Download': 'Download',
      'Update Status': 'Update Status',
      'Search orders...': 'Search orders...',
      'No orders found': 'No orders found',
      // Add more translations
    }
  }
  // Add more languages as needed
}

export default createI18n({
  locale: getLanguage(),
  fallbackLocale: 'en',
  messages
})