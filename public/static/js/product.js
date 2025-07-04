const { createApp } = Vue

createApp({
    data() {
        return {
            products: [],
            newProduct: {
                name: '',
                description: '',
                unit: 'un',
                price: ''
            }
        }
    },
    methods: {
        async fetchProducts() {
            const res = await fetch('/products/index')
            this.products = await res.json()
        },
        async createProduct() {
            const res = await fetch('/products', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(this.newProduct)
            })

            if (res.ok) {
                this.fetchProducts()
                this.newProduct = { name: '', description: '', unit: '', price: '' }
            } else {
                const error = await res.json()
                alert(error.error || 'Erro ao cadastrar produto')
            }
        }
    },
    mounted() {
        this.fetchProducts()
    }
}).mount('#app')
