import '@fortawesome/fontawesome-free/css/all.min.css'
import './bootstrap'
import 'flowbite'
import axios from 'axios'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import { ZiggyVue } from 'ziggy-js'

// Set up axios CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        return pages[`./pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(ZiggyVue, plugin)
            .mount(el)
    }
})
