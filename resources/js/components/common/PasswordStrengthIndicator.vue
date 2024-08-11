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
export default {
    name: 'PasswordStrengthIndicator',
    props: {
        password: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            passwordStrength: 0,
            passwordStrengthClass: 'bg-red-500',
            passwordStrengthMessage: 'Weak'
        }
    },
    watch: {
        password(newPassword) {
            this.checkPasswordStrength(newPassword)
        }
    },
    methods: {
        checkPasswordStrength(password) {
            let strength = 0

            if (password.length >= 8) strength += 1
            if (password.length >= 12) strength += 1
            if (password.match(/[A-Z]/)) strength += 1
            if (password.match(/[a-z]/)) strength += 1
            if (password.match(/[0-9]/)) strength += 1
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1

            this.passwordStrength = (strength / 6) * 100

            if (strength <= 2) {
                this.passwordStrengthClass = 'bg-red-500'
                this.passwordStrengthMessage = 'Weak'
            } else if (strength <= 4) {
                this.passwordStrengthClass = 'bg-yellow-500'
                this.passwordStrengthMessage = 'Moderate'
            } else {
                this.passwordStrengthClass = 'bg-green-500'
                this.passwordStrengthMessage = 'Strong'
            }
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
