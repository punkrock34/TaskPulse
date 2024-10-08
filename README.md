# TaskPulse

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)
![Firebase](https://img.shields.io/badge/Firebase-FFCA28?style=for-the-badge&logo=firebase&logoColor=black)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)

TaskPulse is a modern, efficient task management web application built with Laravel and Vue.js. It leverages Firebase for authentication and Docker (via DDEV) for easy local development.

## 🌟 Features

- **Secure Authentication**: Powered by Firebase for reliable user login and registration
- **Comprehensive Task Management**: Easily create and update tasks
- **Attachment Support**: Seamlessly add and remove attachments within tasks
- **Intelligent Categorization**: Prioritize and track tasks with priority labels and status indicators
- **Responsive Design**: Enjoy a clean, intuitive interface optimized for both desktop and mobile

## 🚀 Quick Start

1. **Prerequisites**: Install [DDEV](https://ddev.readthedocs.io/en/stable/) and [Docker](https://www.docker.com/get-started)
2. **Clone**: `git clone https://github.com/punkrock34/TaskPulse.git`
3. **Setup**:

   ```sh
   ddev start
   cp .env.example .env
   ddev composer update
   ddev npm install
   ddev artisan key:generate
   ddev artisan migrate
   ```

   💡 If `ddev npm install` hangs, it may be due to a [known npm issue](https://github.com/npm/cli/issues/4028). As a workaround, try opening a new terminal, removing the node_modules folder, and running `ddev npm install` again.


4. **Configure Firebase**:
   - Download `firebase_credentials.json` from [Firebase Console](https://console.firebase.google.com/)
   - Place it in `storage/app/firebase/`
   - Update `.env` with Firebase credentials
5. **Run**:
   - Terminal 1: `ddev npm run dev`
   - Terminal 2: `ddev launch`

Visit [https://taskpulse.ddev.site](https://taskpulse.ddev.site) to see your app in action!

For detailed instructions, check the [Installation Guide](./docs/installation.md).

## 📚 Documentation

- [Installation Guide](./docs/installation.md): Detailed setup instructions
- [Development Setup](./docs/development.md): Guide for developers
- [Resources](./docs/resources.md): Links to documentation for all technologies used in this project
- [Contributing Guidelines](./CONTRIBUTING.md): How to contribute to the project

## 🛠 Technologies

- **Backend**: Laravel, PHP
- **Frontend**: Vue.js, Inertia.js
- **Build Tool**: Vite
- **Authentication**: Firebase
- **Database**: MySQL (via DDEV)
- **Development Environment**: Docker, DDEV

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guidelines](./CONTRIBUTING.md) for more details on how to get started.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE.md) file for details.

## 📞 Support

If you encounter any problems or have questions, please [open an issue](https://github.com/punkrock34/TaskPulse/issues/new) on GitHub.

---

Made with ❤️ by [punkrock34](https://github.com/punkrock34) as a university project
