import axios from 'axios'

export default {
    data() {
        return {
            statusMessage: '',
            errorMessage: '',
            validationErrors: []
        }
    },
    methods: {
        async loginUser(credentials) {
            try {
                const response = await axios.post('/api/login', credentials)
                this.handleSuccess(response.data.message || 'Logged in successfully')
                this.$router.push({ name: 'dashboard' })
            } catch (error) {
                this.handleError(error)
            }
        },
        async registerUser(credentials) {
            try {
                const response = await axios.post('/api/register', credentials)
                this.handleSuccess(response.data.message || 'Registered successfully')
                this.$router.push({ name: 'login' })
            } catch (error) {
                this.handleError(error)
            }
        },
        async resetUserPassword(credentials) {
            try {
                const response = await axios.post('/api/reset-password', credentials)
                this.handleSuccess(response.data.message || 'Password reset successfully')
            } catch (error) {
                this.handleError(error)
            }
        },
        signInWithGoogle() {
            // Implement Google sign-in logic here
        },
        handleSuccess(message) {
            this.statusMessage = message
            this.errorMessage = ''
            this.validationErrors = []
        },
        handleError(error) {
            if (error.response && error.response.status === 422) {
                this.validationErrors = Object.values(error.response.data.errors).flat()
                this.statusMessage = ''
                this.errorMessage = ''
            } else {
                this.errorMessage = error.response ? error.response.data.error : 'An error occurred'
                this.statusMessage = ''
                this.validationErrors = []
            }
        },
        hasError(field) {
            return this.validationErrors.some((error) => error.toLowerCase().includes(field))
        },
        getError(field) {
            const error = this.validationErrors.find((error) => error.toLowerCase().includes(field))
            return error ? error : ''
        }
    }
}
