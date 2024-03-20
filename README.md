# Alibaba-blog

Alibaba-blog is a Laravel project for creating and managing a blog. This README provides instructions for setting up and deploying the project using Docker Compose.

## Table of Contents

- [Alibaba-blog](#alibaba-blog)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [To Create Admin User manually](#to-create-admin-user-manually)
  - [Creating User](#creating-user)
    - [1. Register on the Site](#1-register-on-the-site)
    - [2. Create from Admin Panel](#2-create-from-admin-panel)
  - [Running Tests](#running-tests)
  - [Credit](#credit)
  - [Code Assignment](#code-assignment)

## Installation

To get started with Alibaba-blog, follow these steps:

1. Clone the repository:

    ```bash
    git clone https://github.com/mousawi/alibaba-blog.git

    ```

2. Create a .env file by copying the example:
    ```bash
    cp .env.example .env
    ```
3. Configure the .env file with your environment variables. You may need to adjust the database settings and any other configuration specific to your environment.
4. Build and start the Docker containers:
    ```bash
    docker compose up -d --build
    ```
5. Install App:
    ```bash
    docker compose exec app install-app
    ```

## Usage

Once the Docker containers are running, you can access the Alibaba-blog application in your web browser at http://localhost:8000. From here, you can create and manage your blog content.

## To Create Admin User manually

To create an admin user for Alibaba-blog, follow these steps:

1. Run the command to create the admin user:

    ```bash
    docker compose exec app php artisan alibaba-blog:create-admin
    ```

Follow the prompts to provide the admin's name, email, and password.

## Creating User

There are two ways to create a user in Alibaba-blog:

### 1. Register on the Site

Users can register on the site by following these steps:

1. Navigate to the registration page.
2. Fill in the required information, including name, email, and password.
3. Submit the registration form.
4. Upon successful registration, you can login to admin panel as user

### 2. Create from Admin Panel

Administrators can create users from the admin panel by following these steps:

1. Log in to the admin panel using your admin credentials.
2. Navigate to the user section.
3. Click on the "New User".
4. Fill in the required user details, including name, email, and password.
5. Submit the form to create the user.

## Running Tests

To ensure Alibaba-blog's functionality, run tests using the following command:

```bash
docker compose exec app php artisan test
```

## Credit

Alibaba-blog is built using the [Laravel](https://laravel.com/) PHP framework and [FailmentPHP](https://filamentphp.com/). We acknowledge and thank the Laravel and FailmentPHP communities for their contributions and support.

## Code Assignment

Alibaba-blog is developed as a code assignment project. If you have any questions or suggestions regarding the implementation, feel free to reach out to us.
