const { createApp, onMounted, ref } = Vue;

createApp({
    setup() {
        const invoices = ref([]);

        onMounted(async () => {
            const res = await fetch('/invoices/index');
            invoices.value = await res.json();
        });

        const formatDate = (dateStr) => {
            const date = new Date(dateStr);
            return date.toLocaleDateString('pt-BR');
        };

        return { invoices, formatDate };
    }
}).mount('#app');
