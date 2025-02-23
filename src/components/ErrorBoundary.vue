<template>
  <div v-if="error" class="error-boundary">
    <div class="error-content">
      <h2>{{ t('printorders', 'Something went wrong') }}</h2>
      <p class="error-message">{{ error.message }}</p>
      <button @click="retry" v-if="retryable">
        {{ t('printorders', 'Retry') }}
      </button>
      <button @click="reset">
        {{ t('printorders', 'Reset') }}
      </button>
    </div>
  </div>
  <slot v-else></slot>
</template>

<script>
export default {
  name: 'ErrorBoundary',
  props: {
    retryable: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      error: null
    }
  },
  methods: {
    retry() {
      this.$emit('retry')
      this.error = null
    },
    reset() {
      this.error = null
    }
  },
  errorCaptured(err) {
    this.error = err
    return false
  }
}
</script>

<style scoped>
.error-boundary {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 200px;
  padding: 20px;
}

.error-content {
  text-align: center;
  max-width: 500px;
}

.error-message {
  margin: 15px 0;
  color: var(--color-error);
}

button {
  margin: 0 5px;
}
</style>