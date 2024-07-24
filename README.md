# TaskPulse

TaskPulse is a web application built with Laravel and Vite, utilizing ddev for local development.

## Quick Start

1. Install prerequisites: ddev and Docker
2. Clone the repository: `git clone https://github.com/punkrock34/TaskPulse.git`
3. Navigate to the project directory: `cd taskpulse`
4. Start the ddev environment: `ddev start`
5. Install dependencies: `ddev composer update && ddev npm install`
6. Copy the environment file: `cp .env.example .env`
7. Launch the application:
    - Terminal 1: ddev npm run dev
    - Terminal 2: ddev launch or go to <https://taskpulse.ddev.site>

For detailed setup instructions and documentation, please refer to the [docs](./docs) folder.

## Documentation

- [Installation Guide](./docs/installation.md)
- [Development Setup](./docs/development.md)
- [Module Documentation](./docs/modules/)
  - [Laravel Reverb](./docs/modules/laravel-reverb.md)
  - [Vite](./docs/modules/vite.md)
- [Troubleshooting](./docs/troubleshooting.md)

## Contributing

[Add information about how to contribute to the project]

## License

[Add license information]
