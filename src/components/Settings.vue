<template>
  <div class="settings">
    <h2>{{ t('printorders', 'Print Orders Settings') }}</h2>
    
    <div class="setting-section">
      <h3>{{ t('printorders', 'PDF Settings') }}</h3>
      
      <div class="setting-item">
        <label>
          {{ t('printorders', 'Company Name') }}
          <input type="text" v-model="settings.companyName">
        </label>
      </div>
      
      <div class="setting-item">
        <label>
          {{ t('printorders', 'Company Logo') }}
          <input type="file" @change="handleLogoUpload" accept="image/*">
        </label>
      </div>
      
      <div class="setting-item">
        <label>
          {{ t('printorders', 'Default Currency') }}
          <select v-model="settings.currency">
            <option value="USD">USD ($)</option>
            <option value="EUR">EUR (€)</option>
            <option value="GBP">GBP (£)</option>
          </select>
        </label>
      </div>
    </div>

    <div class="setting-section">
      <h3>{{ t('printorders', 'Notification Settings') }}</h3>
      
      <div class="setting-item">
        <label>
          <input type="checkbox" v-model="settings.emailNotifications">
          {{ t('printorders', 'Enable email notifications') }}
        </label>
      </div>
    </div>

    <div class="actions">
      <button @click="saveSettings" :disabled="saving">
        {{ saving ? t('printorders', 'Saving...') : t('printorders', 'Save Settings') }}
      </button>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { showSuccess, showError } from '@nextcloud/dialogs'

export default {
  name: 'Settings',
  setup() {
    const settings = ref({
      companyName: '',
      currency: 'USD',
      emailNotifications: true
    })
    const saving = ref(false)

    const loadSettings = async () => {
      try {
        const response = await fetch(OC.generateUrl('/apps/printorders/settings'))
        const data = await response.json()
        settings.value = { ...settings.value, ...data }
      } catch (error) {
        console.error('Error loading settings:', error)
        showError(t('printorders', 'Could not load settings'))
      }
    }

    const saveSettings = async () => {
      saving.value = true
      try {
        await fetch(OC.generateUrl('/apps/printorders/settings'), {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(settings.value)
        })
        showSuccess(t('printorders', 'Settings saved successfully'))
      } catch (error) {
        console.error('Error saving settings:', error)
        showError(t('printorders', 'Could not save settings'))
      }
      saving.value = false
    }

    const handleLogoUpload = async (event) => {
      const file = event.target.files[0]
      if (file) {
        const formData = new FormData()
        formData.append('logo', file)
        
        try {
          await fetch(OC.generateUrl('/apps/printorders/settings/logo'), {
            method: 'POST',
            body: formData
          })
          showSuccess(t('printorders', 'Logo uploaded successfully'))
        } catch (error) {
          console.error('Error uploading logo:', error)
          showError(t('printorders', 'Could not upload logo'))
        }
      }
    }

    // Load settings when component mounts
    loadSettings()

    return {
      settings,
      saving,
      saveSettings,
      handleLogoUpload
    }
  }
}
</script>

<style scoped>
.settings {
  max-width: 800px;
  margin: 0 auto;
}

.setting-section {
  margin-bottom: 30px;
}

.setting-item {
  margin: 15px 0;
}

.setting-item label {
  display: block;
  margin-bottom: 5px;
}

.setting-item input[type="text"],
.setting-item select {
  width: 100%;
  max-width: 300px;
}

.actions {
  margin-top: 20px;
}

button {
  min-width: 120px;
}
</style>