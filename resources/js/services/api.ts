import axios, { AxiosInstance } from 'axios'

const api: AxiosInstance = axios.create({
    baseURL: '/api/v1',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true,
    withXSRFToken: true,
})

// Add request interceptor for authentication
api.interceptors.request.use(
    (config) => {
        // The CSRF token is automatically handled by Axios withXSRFToken
        return config
    },
    (error) => {
        return Promise.reject(error)
    }
)

// Add response interceptor for error handling
api.interceptors.response.use(
    (response) => {
        return response
    },
    (error) => {
        if (error.response) {
            // Handle specific error codes
            switch (error.response.status) {
                case 401:
                    // Unauthorized
                    window.location.href = '/login'
                    break
                case 403:
                    // Forbidden
                    console.error('Access forbidden')
                    break
                case 404:
                    // Not found
                    console.error('Resource not found')
                    break
                case 422:
                    // Validation error - handled by caller
                    break
                case 500:
                    // Server error
                    console.error('Server error occurred')
                    break
            }
        }
        return Promise.reject(error)
    }
)

export default api
