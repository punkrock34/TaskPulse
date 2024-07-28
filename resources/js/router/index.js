import { createRouter, createWebHistory } from 'vue-router'
import LoginForm from '../components/auth/LoginForm.vue'
import RegisterForm from '../components/auth/RegisterForm.vue'
import ForgotPasswordForm from '../components/auth/ForgotPasswordForm.vue'
import ResetPasswordForm from '../components/auth/ResetPasswordForm.vue'
import AppDashboard from '../components/AppDashboard.vue'
import NotFound from '../components/NotFound.vue'
// Import other components

const routes = [
    { path: '/', component: LoginForm },
    { path: '/register', component: RegisterForm },
    { path: '/forgot-password', component: ForgotPasswordForm },
    { path: '/reset-password/:code', component: ResetPasswordForm, name: 'reset-password' },

    { path: '/dashboard', component: AppDashboard, name: 'dashboard' },

    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound } // 404 route
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
