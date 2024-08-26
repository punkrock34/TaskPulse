# TaskPulse

TaskPulse is a web application built with Laravel and Vite, utilizing ddev for local development. It helps manage tasks efficiently with a user-friendly interface.

## Features

- User Authentication and Authorization via Firebase
- Task CRUD operations
- Task labeling
- Task status
- Due date notification system

## Quick Start

1. Install prerequisites: ddev and Docker
2. Clone the repository: `git clone https://github.com/punkrock34/TaskPulse.git`
3. Navigate to the project directory: `cd taskpulse`
4. Start the ddev environment: `ddev start`
5. Install dependencies: `ddev composer update && ddev npm install`
6. Copy the environment file: `cp .env.example .env`
7. **Obtain Firebase credentials**:
   - Download `firebase_credentials.json` from the Firebase Console and place it in the `storage/app/firebase` directory.
   - Add Firebase credentials to `.env` as described in the Environment Setup section.
8. **Configure Mail settings (optional)**:
   - Add Mail settings to `.env` as described in the Environment Setup section.
9. Launch the application:
   - Terminal 1: `ddev npm run dev`
   - Terminal 2: `ddev launch` or go to [https://taskpulse.ddev.site](https://taskpulse.ddev.site)

For detailed setup instructions and documentation, please refer to the [docs](./docs) folder.

## Documentation

- [Installation Guide](./docs/installation.md)
- [Development Setup](./docs/development.md)

## Technologies Used

- Laravel
- Vite
- Vue
- Inertia
- Firebase
- Docker

## Contributing

Contributions are welcome! Please fork the repository and submit pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE.md) file for details.
