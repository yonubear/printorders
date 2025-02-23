const baseUrl = OC.generateUrl('/apps/printorders')

export default {
    // Order related API calls
    async getOrders() {
        const response = await fetch(`${baseUrl}/orders`)
        return response.json()
    },

    async getOrder(id) {
        const response = await fetch(`${baseUrl}/orders/${id}`)
        return response.json()
    },

    async createOrder(orderData) {
        const response = await fetch(`${baseUrl}/orders`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
        })
        return response.json()
    },

    async updateOrder(id, orderData) {
        const response = await fetch(`${baseUrl}/orders/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
        })
        return response.json()
    },

    // PDF related API calls
    async downloadOrderPDF(id) {
        window.location.href = `${baseUrl}/pdf/${id}/download`
    },

    async previewOrderPDF(id) {
        window.location.href = `${baseUrl}/pdf/${id}/preview`
    },

    async downloadBatchPDF(orderIds) {
        const queryString = orderIds.map(id => `id[]=${id}`).join('&')
        window.location.href = `${baseUrl}/pdf/batch?${queryString}`
    }
}