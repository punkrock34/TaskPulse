# TaskPulse Installation Guide

## Prerequisites

- Docker
- DDEV

## Detailed Installation Steps

### 1. Install Docker

#### Windows

- Download and install Docker Desktop from the [official Docker website](https://www.docker.com/products/docker-desktop).
- Follow the on-screen instructions to complete the installation.
- Start Docker Desktop from the Start menu.
- Verify the installation: Run `docker --version` in Command Prompt or PowerShell.

#### macOS

- Use Homebrew to install Docker:

  ```sh
  brew install --cask docker
  ```

- Start Docker from the Applications folder.
- Verify the installation: Run `docker --version` in the terminal.

#### Linux

- Follow the [official Docker installation guide for Linux](https://docs.docker.com/engine/install/#server).
- After installation, start Docker: `sudo systemctl start docker`
- Verify the installation: Run `docker --version` in the terminal.

### 2. Install DDEV

#### Windows

- Download the DDEV Windows installer from the [DDEV releases page](https://github.com/drud/ddev/releases).
- Run the installer and follow the on-screen instructions.
- Verify the installation: Run `ddev version` in Command Prompt or PowerShell.

#### macOS

Choose one of the following methods:

- Using Homebrew:

  ```sh
  brew install ddev/ddev/ddev
  ```

- Using Install Script:

  ```sh
  curl -fsSL https://ddev.com/install.sh | bash
  ```

- One-time initialization of mkcert:

  ```sh
  mkcert -install
  ```

- Verify the installation: Run `ddev version` in the terminal.

#### Linux

Choose the appropriate method for your distribution:

- Debian/Ubuntu:

  ```sh
  sudo apt-get update && sudo apt-get install -y curl
  sudo install -m 0755 -d /etc/apt/keyrings
  curl -fsSL https://pkg.ddev.com/apt/gpg.key | gpg --dearmor | sudo tee /etc/apt/keyrings/ddev.gpg > /dev/null
  sudo chmod a+r /etc/apt/keyrings/ddev.gpg
  echo "deb [signed-by=/etc/apt/keyrings/ddev.gpg] https://pkg.ddev.com/apt/ * *" | sudo tee /etc/apt/sources.list.d/ddev.list >/dev/null
  sudo apt-get update && sudo apt-get install -y ddev
  mkcert -install
  ```

- Fedora, Red Hat, etc.:

  ```sh
  echo '[ddev]
  name=ddev
  baseurl=https://pkg.ddev.com/yum/
  gpgcheck=0
  enabled=1' | perl -p -e 's/^ +//' | sudo tee /etc/yum.repos.d/ddev.repo >/dev/null
  sudo dnf install --refresh ddev
  mkcert -install
  ```

- Arch Linux:

  ```sh
  yay -S ddev-bin
  mkcert -install
  ```

- Using Install Script (all distributions):

  ```sh
  curl -fsSL https://ddev.com/install.sh | bash
  ```

Verify the installation: Run `ddev version` in the terminal.

## Project Setup

After installing the prerequisites and cloning the repository, follow these steps:

1. Copy the example environment file:

   ```sh
   cp .env.example .env
   ```

2. Set up a Firebase project:
   - Go to the [Firebase Console](https://console.firebase.google.com/) and create a new project or select an existing one.
   - Navigate to your project settings.
   - Download the `firebase_credentials.json` file.
   - Place the `firebase_credentials.json` file in the `storage/app/firebase` directory of your project.

3. (Optional) Enable Google Sign-In for Firebase:
   If you want to use Google Sign-In in your application, follow these steps:
   - In the [Firebase Console](https://console.firebase.google.com/), go to Authentication > Sign-in method.
   - Enable the Google sign-in provider.
   - Add your application's domain (e.g., taskpulse.ddev.site) to the authorized domains list in Firebase Authentication settings.

   Note: If you don't need Google Sign-In, you can skip this step. The application will still use Firebase for email/password authentication, but the login/sign in with firebase will not work!

4. Add Firebase credentials to .env:
   - Open the `.env` file and add the following, replacing placeholders with your Firebase project details:

     ```env
     VITE_FIREBASE_API_KEY=<your-firebase-api-key>
     VITE_FIREBASE_AUTH_DOMAIN=<your-firebase-auth-domain>
     VITE_FIREBASE_PROJECT_ID=<your-firebase-project-id>
     VITE_FIREBASE_STORAGE_BUCKET=<your-firebase-storage-bucket>
     VITE_FIREBASE_MESSAGING_SENDER_ID=<your-firebase-messaging-sender-id>
     VITE_FIREBASE_APP_ID=<your-firebase-app-id>
     VITE_FIREBASE_MEASUREMENT_ID=<your-firebase-measurement-id>
     ```

5. (Optional) Configure Mail settings:
   - If you want to use Mailhog with `ddev`, add these to your `.env` file:

     ```env
     MAIL_MAILER="smtp"
     MAIL_HOST="127.0.0.1"
     MAIL_PORT="1025"
     MAIL_USERNAME=null
     MAIL_PASSWORD=null
     MAIL_ENCRYPTION=null
     MAIL_FROM_ADDRESS="hello@example.com"
     MAIL_FROM_NAME="${APP_NAME}"
     ```

6. Start the DDEV environment:

   ```sh
   ddev start
   ```

7. Install Composer dependencies:

   ```sh
   ddev composer update
   ```

8. Generate application key:

   ```sh
   ddev artisan key:generate
   ```

9. Run database migrations:

   ```sh
   ddev artisan migrate
   ```

   This step creates the necessary database tables. If skipped, you may encounter a SQLSTATE[42S02] error.

10. Run tests to verify setup:

    ```sh
    ddev artisan test
    ```

11. Install NPM dependencies:

    ```sh
    ddev npm install --no-progress
    ```

    Note: If `ddev npm install` hangs, it may be due to a [known npm issue](https://github.com/npm/cli/issues/4028). As a workaround, try opening a new terminal, removing the node_modules folder, and running `ddev npm install` again.

12. Run Vite (in a secondary terminal):

    ```sh
    ddev npm run dev
    ```

13. Launch the application:

    ```sh
    ddev launch
    ```

    This opens the application in your default web browser. The URL should match the APP_URL in your `.env` file.

## Database Management

### CLI Access

To interact with the database via CLI:

```sh
ddev mysql
```

### GUI Options

#### HeidiSQL (Windows only, can be used via WSL)

1. Install HeidiSQL:
   - Download and install HeidiSQL from the [official website](https://www.heidisql.com/download.php).
   - Follow the installation instructions provided on the website.

2. Launch HeidiSQL with DDEV:
   - Once HeidiSQL is installed, you can use DDEV to launch it with the correct connection details:

     ```sh
     ddev heidisql
     ```

   - This command will open HeidiSQL with the connection details for your DDEV project's database.

3. Manual Connection:
   - Alternatively, you can launch HeidiSQL manually and connect using the details from:

     ```sh
     ddev describe
     ```

   - Use the provided host, username, password, and port to set up the connection in HeidiSQL.

Note: The `ddev heidisql` only launches the already installed application with the appropriate connection details for your DDEV project.

#### phpMyAdmin

1. Install ddev-phpmyadmin:

   ```sh
   ddev get ddev/ddev-phpmyadmin
   ```

2. Restart DDEV:

   ```sh
   ddev restart
   ```

3. Launch phpMyAdmin:

   ```sh
   ddev phpmyadmin
   ```

#### Other GUI Clients

- Sequel Ace (macOS): `ddev sequelace`
- TablePlus (macOS): `ddev tableplus`
- Querious (macOS): `ddev querious`
- DBeaver (WSL2, Linux, macOS): `ddev dbeaver`
- PhpStorm: Built-in database browser (automatic setup with DDEV Integration plugin)

### Custom Database Ports

To use a static host database port:

1. In your DDEV configuration, add:

   ```yaml
   host_db_port: 59002
   ```

   Replace 59002 with your preferred port.

2. Apply changes:

   ```sh
   ddev start
   ```

### MySQL Workbench

1. Set up MySQL Workbench:

   ```sh
   cp ~/.ddev/commands/host/mysqlworkbench.example ~/.ddev/commands/host/mysqlworkbench
   ```

2. Launch MySQL Workbench:

   ```sh
   ddev mysqlworkbench
   ```

## Troubleshooting

If you encounter issues:

1. Restart the DDEV environment:

   ```sh
   ddev restart
   ```

2. Clear Laravel caches:

   ```sh
   ddev artisan cache:clear
   ddev artisan config:clear
   ddev artisan view:clear
   ```

If problems persist, check the project's issue tracker or create a new issue.
