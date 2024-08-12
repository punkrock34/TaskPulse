<template>
    <div class="relative">
        <div class="h-2 w-full bg-gray-300 rounded-full mt-1">
            <div
                :class="passwordStrengthClass"
                :style="{ width: passwordStrength + '%' }"
                class="h-full rounded-full transition-all duration-300"
            ></div>
        </div>
        <p
            v-if="passwordStrengthMessage"
            :class="passwordStrengthClass + '-text'"
            class="text-xs mt-1"
        >
            {{ passwordStrengthMessage }}
        </p>
    </div>
</template>

<script>
import { ref, watch } from 'vue'

export default {
    name: 'PasswordStrengthIndicator',
    props: {
        password: {
            type: String,
            required: true
        }
    },
    setup(props) {
        const passwordStrength = ref(0)
        const passwordStrengthClass = ref('bg-red-500')
        const passwordStrengthMessage = ref('Weak')

        const updateStrength = () => {
            let strength = 0
            const password = props.password

            if (password.length >= 8) strength += 1
            if (password.length >= 12) strength += 1
            if (/[A-Z]/.test(password)) strength += 1
            if (/[a-z]/.test(password)) strength += 1
            if (/[0-9]/.test(password)) strength += 1
            if (/[^a-zA-Z0-9]/.test(password)) strength += 1

            passwordStrength.value = (strength / 6) * 100

            if (strength <= 2) {
                passwordStrengthClass.value = 'bg-red-500'
                passwordStrengthMessage.value = 'Weak'
            } else if (strength <= 4) {
                passwordStrengthClass.value = 'bg-yellow-500'
                passwordStrengthMessage.value = 'Moderate'
            } else {
                passwordStrengthClass.value = 'bg-green-500'
                passwordStrengthMessage.value = 'Strong'
            }
        }

        watch(() => props.password, updateStrength, { immediate: true })

        return {
            passwordStrength,
            passwordStrengthClass,
            passwordStrengthMessage
        }
    }
}
</script>

<style scoped>
.bg-red-500-text {
    color: #ef4444;
}

.bg-yellow-500-text {
    color: #f59e0b;
}

.bg-green-500-text {
    color: #10b981;
}
</style>
