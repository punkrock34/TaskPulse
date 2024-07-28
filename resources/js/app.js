import '@fortawesome/fontawesome-free/css/all.min.css'
import axios from 'axios'
import { createApp } from 'vue'
import './bootstrap'
import 'flowbite'
import App from './App.vue'
import router from './router'

// Set up axios CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken

// Create and mount Vue app
const app = createApp(App)
app.use(router)
app.mount('#app')
