const { createApp } = Vue;

createApp({
    data() {
        return {
            clients: [],
            newClient: {
                name: '',
                cpfcnpj: '',
                email: '',
                address: '',
                phone: ''
            }
        };
    },
    methods: {
        async fetchClients() {
            try {
                const res = await fetch('/clients/index');
                this.clients = await res.json();
            } catch (error) {
                alert('Erro ao buscar clientes');
            }
        },
        async createClient() {
            try {
                const res = await fetch('/clients', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams(this.newClient)
                });

                if (res.ok) {
                    this.fetchClients();
                    this.newClient = {
                        name: '',
                        cpfcnpj: '',
                        email: '',
                        address: '',
                        phone: ''
                    };
                } else {
                    const error = await res.json();
                    alert(error.details || 'Erro no JS');
                }
            } catch (error) {
                alert('Erro de comunicação com o servidor');
            }
        }
    },
    mounted() {
        this.fetchClients();
    }
}).mount('#app');
