import './bootstrap'
import 'flowbite'
import '@fortawesome/fontawesome-free/css/all.min.css'

var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon')
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon')

// Change the icons inside the button based on previous settings
if (
    localStorage.getItem('color-theme') === 'dark' ||
    (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
    themeToggleLightIcon.classList.remove('hidden')
} else {
    themeToggleDarkIcon.classList.remove('hidden')
}

var themeToggleBtn = document.getElementById('theme-toggle')

themeToggleBtn.addEventListener('click', function () {
    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle('hidden')
    themeToggleLightIcon.classList.toggle('hidden')

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark')
            localStorage.setItem('color-theme', 'dark')
        } else {
            document.documentElement.classList.remove('dark')
            localStorage.setItem('color-theme', 'light')
        }

        // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark')
            localStorage.setItem('color-theme', 'light')
        } else {
            document.documentElement.classList.add('dark')
            localStorage.setItem('color-theme', 'dark')
        }
    }
})

const togglePassword = document.getElementById('togglePassword')
const password = document.getElementById('password')

const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation')
const passwordConfirmation = document.getElementById('password_confirmation')

const passwordStrengthIndicator = document.getElementById('password-strength-indicator').children

function toggleVisibility(button, input) {
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password'
    input.setAttribute('type', type)
    const icon = button.querySelector('i')
    if (type === 'password') {
        icon.classList.remove('fa-eye-slash')
        icon.classList.add('fa-eye')
    } else {
        icon.classList.remove('fa-eye')
        icon.classList.add('fa-eye-slash')
    }
}

function evaluatePasswordStrength(value) {
    let strength = 'Weak'

    if (
        value.length >= 12 &&
        /[a-z]/.test(value) &&
        /[A-Z]/.test(value) &&
        /[0-9]/.test(value) &&
        /[\W]/.test(value)
    ) {
        strength = 'Strong'
    } else if (
        value.length >= 8 &&
        ((/[a-z]/.test(value) && /[A-Z]/.test(value)) ||
            (/[A-Z]/.test(value) && /[0-9]/.test(value)) ||
            (/[0-9]/.test(value) && /[\W]/.test(value)))
    ) {
        strength = 'Medium'
    }

    return strength
}

function updateStrengthIndicator(strength) {
    const opacities = {
        Weak: [1, 0.3, 0.3],
        Medium: [1, 1, 0.3],
        Strong: [1, 1, 1]
    }

    const [redOpacity, yellowOpacity, greenOpacity] = opacities[strength]

    passwordStrengthIndicator[0].style.opacity = redOpacity
    passwordStrengthIndicator[1].style.opacity = yellowOpacity
    passwordStrengthIndicator[2].style.opacity = greenOpacity
}

togglePassword?.addEventListener('click', function () {
    toggleVisibility(togglePassword, password)
})

togglePasswordConfirmation?.addEventListener('click', function () {
    toggleVisibility(togglePasswordConfirmation, passwordConfirmation)
})

password?.addEventListener('input', function () {
    const value = password.value
    const strength = evaluatePasswordStrength(value)

    updateStrengthIndicator(strength)
})
