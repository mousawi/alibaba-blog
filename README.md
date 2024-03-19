# Alibaba-blog

Alibaba-blog is a Laravel project for creating and managing a blog. This README provides instructions for setting up and deploying the project using Docker Compose.

## Table of Contents

- [Alibaba-blog](#alibaba-blog)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Creating Admin User](#creating-admin-user)
  - [Creating User](#creating-user)
    - [1. Register on the Site](#1-register-on-the-site)
    - [2. Create from Admin Panel](#2-create-from-admin-panel)
  - [Credit](#credit)
  - [Code Assignment](#code-assignment)

## Installation

To get started with Alibaba-blog, follow these steps:

1. Clone the repository:

    ```bash
    git clone https://github.com/your_username/alibaba-blog.git

    ```

2. Create a .env file by copying the example:
    ```bash
    cp .env.example .env
    ```
3. Configure the .env file with your environment variables. You may need to adjust the database settings and any other configuration specific to your environment.
4. Build and start the Docker containers:
    ```bash
    docker-compose up -d --build
    ```
5. Install Composer dependencies:
   ```bash
   docker-compose exec app composer install
6. Generate an application key:
   ```bash
   docker-compose exec app php artisan key:generate

## Usage

Once the Docker containers are running, you can access the Alibaba-blog application in your web browser at http://localhost:8000. From here, you can create and manage your blog content.

## Creating Admin User

To create an admin user for Alibaba-blog, follow these steps:

1. Run the migration to set up the database tables:

    ```bash
    docker-compose exec app php artisan migrate

    ```

2. Run the command to create the admin user:

    ```bash
    docker-compose exec app php artisan alibaba-blog:create-admin
    ```

Follow the prompts to provide the admin's name, email, and password.

## Creating User
There are two ways to create a user in Alibaba-blog:

### 1. Register on the Site

Users can register on the site by following these steps:

1. Navigate to the registration page.
2. Fill in the required information, including name, email, and password.
3. Submit the registration form.
4. Upon successful registration, the user will receive a confirmation email if email verification is enabled.

### 2. Create from Admin Panel

Administrators can create users from the admin panel by following these steps:

1. Log in to the admin panel using your admin credentials.
2. Navigate to the user management section.
3. Click on the "Create User" or similar button.
4. Fill in the required user details, including name, email, and password.
5. Submit the form to create the user.

Choose the method that best suits your needs for creating users in Alibaba-blog.

## Credit

Alibaba-blog is built using the Laravel PHP framework and FailmentPHP. We acknowledge and thank the Laravel and FailmentPHP communities for their contributions and support.

## Code Assignment

Alibaba-blog is developed as a code assignment project. If you have any questions or suggestions regarding the implementation, feel free to reach out to us.
