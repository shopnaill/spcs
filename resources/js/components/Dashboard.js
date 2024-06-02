import axios from 'axios';
import Echo from 'laravel-echo'; // Assuming you have installed and configured Laravel Echo

export default {
    template: `
        <div>
            <h1>Support Requests</h1>
            <ul>
                <li v-for="request in supportRequests" :key="request.id">
                    <strong>{{ request.requester_name }}</strong> ({{ request.requester_email }}): {{ request.message }}
                </li>
            </ul>
        </div>
    `,
    data() {
        return {
            supportRequests: []
        };
    },
    methods: {
        fetchData() {
            axios.get('/api/support-requests').then(response => {
                this.supportRequests = response.data;
            });
        },
        setupEcho() {
            Echo.channel('support-requests')
                .listen('SupportRequestReceived', (event) => {
                    this.supportRequests.push(event.supportRequest);
                });
        }
    },
    created() {
        this.fetchData();
        this.setupEcho();
    }
}
