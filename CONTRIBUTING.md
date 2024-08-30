# Contributing to TaskPulse

Thanks for your interest in contributing to TaskPulse! Here's a quick guide to get you started.

## Getting Started

1. Fork the repository
2. Clone your fork: `git clone https://github.com/punkrock34/TaskPulse.git`
3. Create a new branch: `git checkout -b feature/your-feature-name`

## Setting Up the Development Environment

Please refer to the [Development Setup](./docs/development.md) guide for detailed instructions on setting up your local environment.

## Making Changes

1. Make your changes in your feature branch
2. Run `ddev npm run prepare` to set up Husky git hooks
3. Make your code changes
4. Stage your changes: `git add .`
5. Commit your changes: `git commit -m "Add some feature"`

   Note: Husky will automatically run the following checks before allowing the commit:
   - `ddev pint`: Runs Laravel Pint for code style fixes
   - `ddev npm run check`: Runs linting and formatting checks
   - `ddev artisan test`: Runs the test suite

   If any of these checks fail, your commit will be prevented. Fix the issues and try committing again.

6. Push to the branch: `git push origin feature/your-feature-name`

## Submitting a Pull Request

1. Go to the [TaskPulse repository](https://github.com/punkrock34/TaskPulse) on GitHub
2. Click the "New pull request" button
3. Select your feature branch from the dropdown
4. Click "Create pull request"

## Code Review

A project maintainer will review your pull request. They may ask for changes or clarifications. Please be patient and responsive during this process.

## Additional Resources

- [Installation Guide](./docs/installation.md)
- [Development Setup](./docs/development.md)

Thank you for contributing to TaskPulse!
