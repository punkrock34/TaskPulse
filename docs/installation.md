# Installation Guide

## Prerequisites

- ddev
- Docker

## Detailed Installation Steps

### Windows

1. **Install Docker Desktop for Windows:**
   - Download Docker Desktop from the [official Docker website](https://www.docker.com/products/docker-desktop).
   - Run the installer and follow the on-screen instructions.
   - After installation, start Docker Desktop from the Start menu.
   - Verify the installation by running `docker --version` in Command Prompt or PowerShell.

2. **Install ddev:**
   - Download the ddev Windows installer from the [ddev releases page](https://github.com/drud/ddev/releases).
   - Run the installer and follow the on-screen instructions.
   - Verify the installation by running `ddev version` in Command Prompt or PowerShell.

### macOS

1. **Install Docker:**
   - Use Homebrew to install Docker:

     ```sh
     brew install --cask docker
     ```

   - Start Docker from the Applications folder.
   - Verify the installation by running `docker --version` in the terminal.

2. **Install ddev:**
   - **Using Homebrew:**

     ```sh
     brew install ddev/ddev/ddev
     ```

   - **Using Install Script:**

     ```sh
     curl -fsSL https://ddev.com/install.sh | bash
     ```

   - One-time initialization of mkcert:

     ```sh
     mkcert -install
     ```

   - Verify the installation by running `ddev version` in the terminal.

### Linux

1. **Install Docker:**
   - Follow the [official Docker installation guide for Linux](https://docs.docker.com/engine/install/#server).
   - After installation, start Docker using `sudo systemctl start docker`.
   - Verify the installation by running `docker --version` in the terminal.

2. **Install ddev:**
   - **Debian/Ubuntu:**

     ```sh
     sudo apt-get update && sudo apt-get install -y curl
     sudo install -m 0755 -d /etc/apt/keyrings
     curl -fsSL https://pkg.ddev.com/apt/gpg.key | gpg --dearmor | sudo tee /etc/apt/keyrings/ddev.gpg > /dev/null
     sudo chmod a+r /etc/apt/keyrings/ddev.gpg
     echo "deb [signed-by=/etc/apt/keyrings/ddev.gpg] https://pkg.ddev.com/apt/ * *" | sudo tee /etc/apt/sources.list.d/ddev.list >/dev/null
     sudo apt-get update && sudo apt-get install -y ddev
     mkcert -install
     ```

   - **Fedora, Red Hat, etc.:**

     ```sh
     echo '[ddev]
     name=ddev
     baseurl=https://pkg.ddev.com/yum/
     gpgcheck=0
     enabled=1' | perl -p -e 's/^ +//' | sudo tee /etc/yum.repos.d/ddev.repo >/dev/null
     sudo dnf install --refresh ddev
     mkcert -install
     ```

   - **Arch Linux:**

     ```sh
     yay -S ddev-bin
     mkcert -install
     ```

   - **Using Install Script:**

     ```sh
     curl -fsSL https://ddev.com/install.sh | bash
     ```

   - Verify the installation by running `ddev version` in the terminal.

## Environment Setup

After installing the prerequisites and cloning the repository, follow these steps to set up the project environment:

1. **Copy the example environment file:**

    ```sh
    cp .env.example .env
    ```

2. **Obtain Firebase credentials:**
   - Go to the Firebase Console and navigate to your project.
   - Download the `firebase_credentials.json` file.
   - Place the `firebase_credentials.json` file in the `storage/app/firebase` directory of your project.

3. **Add Firebase credentials to .env:**
   - Open the `.env` file.
   - Add the following environment variables, replacing the placeholders with the values from your Firebase project:

     ```env
     VITE_FIREBASE_API_KEY=<your-firebase-api-key>
     VITE_FIREBASE_AUTH_DOMAIN=<your-firebase-auth-domain>
     VITE_FIREBASE_PROJECT_ID=<your-firebase-project-id>
     VITE_FIREBASE_STORAGE_BUCKET=<your-firebase-storage-bucket>
     VITE_FIREBASE_MESSAGING_SENDER_ID=<your-firebase-messaging-sender-id>
     VITE_FIREBASE_APP_ID=<your-firebase-app-id>
     VITE_FIREBASE_MEASUREMENT_ID=<your-firebase-measurement-id>
     ```

4. **(Optional) Configure Mail settings:**
   - If you want to use Mailhog with `ddev`, add these variables to your `.env` file:

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

5. **Start the ddev environment:**

    ```sh
    ddev start
    ```

6. **Install Composer dependencies:**

    ```sh
    ddev composer update
    ```

7. **Generate application key:**

    ```sh
    ddev artisan key:generate
    ```

8. **Configure settings:**
   - Open the `.env` file and replace where needed.

9. **Run tests to verify setup:**

    ```sh
    ddev artisan test
    ```

10 **Install NPM dependencies:**

    ```sh
    ddev npm install
    ```

11. **In a secondary terminal window, run Vite:**

    ```sh
    ddev npm run dev
    ```

12. **Launch the application:**

    ```sh
    ddev launch
    ```

    This command will open the application in your default web browser. The URL should match the APP_URL in your `.env` file.

13. **Database management (optional):**

    To interact with the database, you can use:

    ```sh
    ddev mysql    
    ```

## Database GUIs

For managing your databases, you can use various GUI clients. Below are instructions for setting up **HeidiSQL** and **phpMyAdmin**.

### HeidiSQL (Windows only, can be used via WSL as well)

HeidiSQL is a lightweight and easy-to-use database client for Windows, which can also be used with WSL2.

1. **Install HeidiSQL:**
    - Download the installation file by running the following command within your `ddev` environment:

      ```sh
      ddev heidisql
      ```

    - Alternatively, you can download it directly from the [official website](https://www.heidisql.com/download.php).

2. **Launch HeidiSQL:**
    - Once installed, you can connect to your database by entering the connection details provided by `ddev describe`. HeidiSQL will allow you to interact with your databases directly from a graphical interface.

### phpMyAdmin

`phpMyAdmin` is a widely-used web interface for managing MySQL and MariaDB databases.

1. **Install ddev-phpmyadmin:**
    - To add phpMyAdmin to your project, run the following command:

      ```sh
      ddev get ddev/ddev-phpmyadmin
      ```

2. **Restart ddev:**
    - After installing phpMyAdmin, you need to restart `ddev` for the changes to take effect:

      ```sh
      ddev restart
      ```

3. **Launch phpMyAdmin:**
    - Access phpMyAdmin through your browser with the following command:

      ```sh
      ddev phpmyadmin
      ```

    - This will open phpMyAdmin where you can manage your databases using a web interface.

### Other GUI Clients

If you prefer other GUI database clients, here are some alternatives:

- **Sequel Ace** (macOS): Launch it with `ddev sequelace` (must be installed).
- **TablePlus** (macOS): Launch it with `ddev tableplus` (must be installed).
- **Querious** (macOS): Launch it with `ddev querious` (must be installed).
- **DBeaver** (WSL2, Linux, macOS): Launch it with `ddev dbeaver` (must be installed).
- **PhpStorm**: PhpStorm and other JetBrains tools have a built-in database browser. If you're using the DDEV Integration plugin, this setup is automatic.

### Custom Database Ports

For projects where you want to use a static host database port, you can set this in your `ddev` configuration:

1. **Set a static port:**
   - In your `ddev` configuration, add the following line under the `database` service:

     ```sh
     host_db_port: 59002
     ```

     Replace `59002` with any port number of your choice, ensuring it doesn't conflict with other services.

2. **Apply the changes:**
   - Run `ddev start` to apply the changes and make the port available.

### MySQL Workbench

There is a sample custom command in `ddev` that allows you to run MySQL Workbench:

1. **Set up MySQL Workbench:**
   - Copy the sample command:

     ```sh
     cp ~/.ddev/commands/host/mysqlworkbench.example ~/.ddev/commands/host/mysqlworkbench
     ```

2. **Launch MySQL Workbench:**
   - Run the command:

     ```sh
     ddev mysqlworkbench
     ```

   - This will open MySQL Workbench if it’s installed on your system.

3. Continue with the remaining steps in the installation guide.

Please note that these updated steps are applicable starting from 2024. Make sure to follow these instructions to ensure a smooth installation process.

After completing these steps, your TaskPulse environment should be ready for development. The `ddev launch` command will open the application in your default web browser.

## Additional Configuration

1. **Configure environment variables:**
Open the `.env` file in a text editor and update the following variables if needed:

- `APP_NAME`: Set to "TaskPulse" or your preferred application name
- `APP_URL`: This should be automatically set by ddev
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: These should be automatically set by ddev
