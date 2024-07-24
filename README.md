# TaskPulse

## Overview

TaskPulse is a web application built with Laravel and Vite, utilizing ddev for local development. It provides [brief description of what TaskPulse does].

## Prerequisites

Before you begin, ensure you have the following:

- **ddev**: An open-source tool for launching local web development environments.
- **Docker**: Required by ddev. You can use Docker Desktop or any other Docker provider.

## Installation

### 1. Install ddev

#### macOS and Linux

1. **Install Homebrew** (if not already installed):

   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

2. **Install Docker** (if not already installed):

   For macOS: Install Docker Desktop from https://www.docker.com/products/docker-desktop
   
   For Linux: Follow the Docker installation guide at https://docs.docker.com/engine/install/ for your distribution

3. **Install ddev**:

   brew install ddev/ddev/ddev

#### Windows

1. Install Docker Desktop from https://www.docker.com/products/docker-desktop
2. Install ddev by following the guide at https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/

### 2. Set up the project

1. Clone the repository:
   git clone https://github.com/punkrock34/TaskPulse.git
   cd taskpulse

2. Copy the example environment file:
   cp .env.example .env

3. Start the ddev environment:
   ddev start

4. Install Composer dependencies:
   ddev composer update

5. Install NPM dependencies:
   ddev npm install

## Usage

1. Start the ddev environment (if not already running):
   ddev start

2. Run Vite development server:
   ddev npm run dev

3. Launch the application in your default web browser:
   ddev launch

## Development

### Using Xdebug

ddev comes with Xdebug pre-installed but disabled by default. To use Xdebug:

1. Enable Xdebug:
   ddev xdebug on

2. Configure your IDE to listen for PHP Debug connections. (.vscode exists in repository already for phpstorm research official documentation)

3. Set breakpoints in your code.

4. Start debugging in your IDE.

5. When finished, you can disable Xdebug to improve performance:
   ddev xdebug off

For more detailed Xdebug configuration, refer to the ddev documentation: https://ddev.readthedocs.io/en/stable/users/debugging-profiling/step-debugging/

### Other Development Commands

- To stop the ddev environment:
  ddev stop

- To run artisan commands:
  ddev artisan [command]

## Additional Information

[Add any other relevant information about your project, such as features, contribution guidelines, or licensing]
