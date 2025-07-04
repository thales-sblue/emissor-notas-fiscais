const { createApp, reactive, computed, onMounted } = Vue;

createApp({
    setup() {
        const invoice = reactive({
            client_id: '',
            notes: '',
            items: []
        });

        const clients = reactive([]);
        const products = reactive([]);

        const addItem = () => {
            invoice.items.push({ product_id: '', quantity: 1 });
        };

        const removeItem = (index) => {
            invoice.items.splice(index, 1);
        };

        const total = computed(() => {
            return invoice.items.reduce((acc, item) => {
                const product = products.find(p => p.id === item.product_id);
                if (!product) return acc;
                return acc + (product.price * item.quantity);
            }, 0);
        });

        const createInvoice = async () => {
            const payload = {
                ...invoice,
                total: total.value
            };

            const res = await fetch('/invoices', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (res.ok) {
                alert('Nota fiscal criada com sucesso!');
                window.location.reload();
            } else {
                const err = await res.json();
                alert(err.details || 'Erro ao criar nota');
            }
        };

        onMounted(async () => {
            const [clientsRes, productsRes] = await Promise.all([
                fetch('/clients/index'),
                fetch('/products/index')
            ]);

            const clientsData = await clientsRes.json();
            const productsData = await productsRes.json();

            clients.push(...clientsData);
            products.push(...productsData);
        });

        return {
            invoice,
            clients,
            products,
            total,
            addItem,
            removeItem,
            createInvoice
        };
    }
}).mount('#app');
