<template>
    <div class="relative mt-2">
        <div class="h-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
            <div
                :class="passwordStrengthClass"
                :style="{ width: passwordStrength + '%' }"
                class="h-full transition-all duration-300"
            ></div>
        </div>
        <p
            v-if="passwordStrengthMessage"
            :class="passwordStrengthMessageClass"
            class="text-sm mt-2 font-medium text-left"
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
        const passwordStrengthMessageClass = ref('text-red-500')

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
                passwordStrengthMessageClass.value = 'text-red-500'
            } else if (strength <= 4) {
                passwordStrengthClass.value = 'bg-yellow-500'
                passwordStrengthMessage.value = 'Moderate'
                passwordStrengthMessageClass.value = 'text-yellow-500'
            } else {
                passwordStrengthClass.value = 'bg-green-500'
                passwordStrengthMessage.value = 'Strong'
                passwordStrengthMessageClass.value = 'text-green-500'
            }
        }

        watch(() => props.password, updateStrength, { immediate: true })

        return {
            passwordStrength,
            passwordStrengthClass,
            passwordStrengthMessage,
            passwordStrengthMessageClass
        }
    }
}
</script>

<style scoped>
.bg-red-500 {
    background-color: #ef4444;
}
.bg-yellow-500 {
    background-color: #f59e0b;
}
.bg-green-500 {
    background-color: #10b981;
}
.text-red-500 {
    color: #ef4444;
}
.text-yellow-500 {
    color: #f59e0b;
}
.text-green-500 {
    color: #10b981;
}
</style>
