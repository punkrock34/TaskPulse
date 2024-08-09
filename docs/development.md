
# Development Guide

## Table of Contents

- [Environment Setup](#environment-setup)
- [Development Workflow](#development-workflow)
- [Useful Commands](#useful-commands)
- [Debugging](#debugging)
  - [PHP XDebug](#php-xdebug)
- [Code Style and Linting](#code-style-and-linting)
- [Database Management](#database-management)
- [Troubleshooting](#troubleshooting)

## Environment Setup

Ensure you've completed all steps in the [Installation Guide](installation.md) before proceeding.

## Development Workflow

1. **Start the development environment:**

    ```sh
    ddev start
    ```

2. **Run Vite development server:**

    ```sh
    ddev npm run dev
    ```

3. **Make your code changes**

4. **Run tests:**

    ```sh
    ddev artisan test
    ```

5. **Commit your changes and push to the repository**

## Useful Commands

- Artisan Commands

    ```sh
    ddev artisan [command]
    ```

    Example: `ddev artisan make:controller UserController`

- Composer Commands

    ```sh
    ddev composer [command]
    ```

    Example: `ddev composer require laravel/lighthouse`

- NPM Commands

    ```sh
    ddev npm [command]
    ```

    Example: `ddev npm run dev`

## Debugging

### PHP XDebug

1. **Enable XDebug:**

    ```sh
    ddev xdebug on
    ```

2. **Configure your IDE to listen for PHP Debug connections:**
   - The repository has `.vscode` configured for port 9003. You can check the configuration in `.vscode/launch.json`.

3. **Automatically Start XDebug in VSCode:**
   - A `tasks.json` file has been added to the `.vscode` folder that can start XDebug automatically. Ensure your VSCode is configured to use these tasks.

4. **Set breakpoints in your code.**

5. **Start debugging in your IDE.**

6. **When finished, disable XDebug:**

    ```sh
    ddev xdebug off
    ```

7. **Manual XDebug Activation (Optional):**
   - Even though XDebug can be started automatically using the provided `tasks.json`, you may still need to manually start it in certain situations. To manually start or stop XDebug, you can use the following commands:

    ```sh
    ddev xdebug on
    ddev xdebug off
    ```

### Code Style and Linting

We use Laravel Pint for PHP code styling. To run Pint:

```
ddev pint
```

For JavaScript and Vue.js files, we use Prettier and ESLint. The `ddev npm run check` command will handle both linting and formatting:

```
ddev npm run check
```

This command runs the following:

- **Lint:** Ensures JavaScript and Vue.js files follow the ESLint rules:
  
  ```sh
  ddev npm run lint
  ```

- **Format:** Formats the JavaScript and Vue.js files using Prettier:
  
  ```sh
  ddev npm run format
  ```

Here’s what `ddev npm run check` does internally:

```json
{
    "scripts": {
        "format": "prettier --write 'resources/js/**/*.{js,vue}'",
        "lint": "eslint 'resources/js/**/*.{js,vue}' --fix",
        "check": "npm run lint && npm run format"
    }
}
```

## Database Management

To access the database via CLI:

```sh
ddev mysql
```

For a GUI interface:

### HeidiSQL

```sh
ddev heidisql
```

### phpMyAdmin

```sh
ddev launch -p
```

## Troubleshooting

If you encounter any issues, try the following:

1. **Restart the ddev environment:**

    ```sh
    ddev restart
    ```

2. **Clear Laravel caches:**

    ```sh
    ddev artisan cache:clear
    ddev artisan config:clear
    ddev artisan view:clear
    ```

If problems persist, please check the issue tracker or create a new issue.

---

This `development.md` covers the basic workflow, useful commands, debugging setup, code style enforcement, database management, and troubleshooting steps.
