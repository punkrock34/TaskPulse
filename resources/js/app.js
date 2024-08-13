import '@fortawesome/fontawesome-free/css/all.min.css'
import axios from 'axios'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import { ZiggyVue } from 'ziggy-js'
import store from './store'

// Set up axios CSRF token
axios.defaults.headers.common['X-CSRF-TOKEN'] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content')

axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        return pages[`./pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(store)
            .use(ZiggyVue, plugin)
            .mount(el)
    }
})
