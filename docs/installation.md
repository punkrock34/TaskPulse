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

2. **Start the ddev environment:**

    ```sh
    ddev start
    ```

3. **Install Composer dependencies:**

    ```sh
    ddev composer update
    ```

4. **Generate application key:**

    ```sh
    ddev artisan key:generate
    ```

5. **Configure Reverb and other settings:**
Open the `.env` and replace `REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET` with your own credentials

6. **Run tests to verify setup:**

    ```sh
    ddev artisan test
    ```

7. **Install NPM dependencies:**

    ```sh
    ddev npm run install
    ```

8. **In a secondary terminal window run vite:**

    ```sh
    ddev npm run dev
    ```

9. **Launch the application:**

   ```sh
   ddev launch
   ```

This command will open the application in your default web browser. The URL should match the APP_URL in your .env file.
10. **Database management (optional):**

To interact with the database, you can use:

```sh
ddev mysql    
```

For a GUI interface, run:

### HeidiSQL

```sh
ddev heidisql
```

### phpmyadmin

```sh
ddev launch -p
```

After completing these steps, your TaskPulse environment should be ready for development. The `ddev launch` command will open the application in your default web browser.

## Additional Configuration

1. **Configure environment variables:**
Open the `.env` file in a text editor and update the following variables if needed:

- `APP_NAME`: Set to "TaskPulse" or your preferred application name
- `APP_URL`: This should be automatically set by ddev
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: These should be automatically set by ddev
