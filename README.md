# Simple Product-Management System

This is a simple Product-Management System built with Laravel, designed to help you manage products easily.

---

## Features
- Manage product information (create, read, update, delete).
- User-friendly interface.
- Built on Laravel framework for maintainability and scalability.

---

## Requirements
Before you start, ensure you have the following installed:
- **PHP**: Version 8.0 or higher.
- **Composer**: For managing dependencies.
- **Laravel**: Version 10 or later.
- **MySQL**: For storing and managing data.

---

## Installation

Follow these steps to set up and run the project locally:

```bash
# Clone the repository
git clone https://github.com/WilliamGeorge1997/Product-Management.git

# Navigate to the project directory
cd Product-Management

# Copy the example environment file and rename it
cp .env.example .env

Update the .env file with your database credentials:

DB_DATABASE=product_management
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

# Install project dependencies
composer install

# Generate the application key
php artisan key:generate

# Run database migrations to set up the required tables
php artisan migrate

# (Optional) Seed the database with sample data
php artisan db:seed

# Start the local development server
php artisan serve
After completing the steps, open your browser and visit:
http://localhost:8000