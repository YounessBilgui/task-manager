# Task Manager

Task Manager is a web application built with Laravel and Livewire. It allows users to create, edit, and manage tasks while administrators can manage users and assign roles. The project leverages Spatie's Laravel Permission package for role-based access control.

## Features

- **Task Dashboard**:  
  - Create and update tasks with a live interface.
  - Mark tasks as completed (using soft deletes for recovery).

- **Admin Panels**:  
  - **User Manager**: Create, delete (accessible only to admins).
  - **Task Manager**: View and manage tasks from all users (accessible only to admins).

- **Role-Based Access Control**:  
  - Users are assigned roles using Spatie's Laravel Permission package.

- **Responsive Design**:  
  - Built with Tailwind CSS for a modern and responsive UI.

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/YounessBilgui/task-manager.git
    ```

2. **Navigate to the project directory:**

    ```bash
    cd task-manager
    ```

3. **Install PHP dependencies:**

    ```bash
    composer install
    ```

4. **Install JavaScript dependencies:**

    ```bash
    npm install
    ```

5. **Copy the environment file and configure your settings:**

    ```bash
    cp .env.example .env
    ```

6. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

7. **Configure your database settings in the [.env](http://_vscodecontentref_/1) file.**

8. **Run the database migrations:**

    ```bash
    php artisan migrate
    ```

9. **Seed the database with initial data:**

    ```bash
    php artisan db:seed
    ```

## Running the Application

To start the development server, run:

```bash
php composer run dev
```