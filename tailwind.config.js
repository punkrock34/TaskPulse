/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.ts',
        './resources/**/*.tsx',
        './node_modules/flowbite/**/*.js'
    ],
    darkMode: 'class',
    plugins: [
        require('flowbite/plugin')
    ]
}
