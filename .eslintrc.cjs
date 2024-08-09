module.exports = {
    root: true,
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-recommended',
        'plugin:prettier/recommended'
    ],
    plugins: ['vue', 'prettier'],
    env: {
        browser: true,
        node: true,
        es2021: true
    },
    parserOptions: {
        ecmaVersion: 2020,
        sourceType: 'module',
        parser: '@babel/eslint-parser',
        requireConfigFile: false
    },
    rules: {
        'prettier/prettier': 'error',
        'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off'
    },
    ignorePatterns: ['node_modules/', 'public/', 'build/']
}
