import axios from 'axios';

const api = axios.create({
    baseURL: '/api/v1', // API v1 - all requests prefixed with /api/v1
    withCredentials: true,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'X-API-Version': 'v1', // API version header for tracking
    },
});

export default api;
