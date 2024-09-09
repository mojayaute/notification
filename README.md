# Notification Test

A web project built with Laravel 10 and Inertia.js that uses React for the front end. This project is configured to run with PHP 8.2+, Node.js 22.7, and MySQL 9.0.

## Table of Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Testing](#testing)

## Introduction

This project is a Laravel 10-based web application utilizing Inertia.js with React for a modern single-page app experience. It provides notification functionalities and can be customized for various use cases.

## Requirements

Before installing, ensure you have the following dependencies installed on your machine:

- **PHP**: 8.2 or higher
- **Node.js**: 22.7 or higher
- **MySQL**: 9.0 or higher
- **Composer**: Latest version
- **NPM**: Latest version

## Installation

Follow these steps to set up the project:

1. Clone the repository:
    ```bash
    git clone https://your-repo-url.git
    cd your-repo-folder
    ```

2. Set up your .env file is not necessary create a new one:
    ```bash
    .env
    ```

   Update the `.env` file with your database and application credentials.

3. Install PHP dependencies via Composer:
    ```bash
    composer install
    ```

4. Install JavaScript dependencies using npm:
    ```bash
    npm install
    ```

5. Run database migrations:
    ```bash
    php artisan migrate
    ```

6. Seed the database:
    ```bash
    php artisan db:seed
    ```

7. Serve the application:
    ```bash
    php artisan serve
    ```

8. In a separate terminal, start the development server for the React frontend:
    ```bash
    npm run dev
    ```

## Usage

Once installed, you can access the web application in your browser by visiting `http://localhost:8000`. Ensure that both the Laravel backend and React frontend are running.

- Login: 
    user: david@example
    pass: secret


## Features

- System that send notifications to each user related to the category choosen in Submission form.
- Each notification will send the notification in base to the channel Suscribed for each user
- I've created the EmailNotification, PushNotification, and SMSNotification classes, which log notifications to the storage/logs/notifications.log file. This functionality is flexible and can be extended or replaced based on future requirements.

## Testing

To run tests for the project, use the following command:
```bash
php artisan test
