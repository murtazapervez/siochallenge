## Project Description
This project serves as a demonstration of a basic project management system. It consists of the following modules:

1. **Project**
2. **Tasks**
3. **Time Logging**

### Project
Users can create and update projects, with the following attributes:

1. Title
2. Description
3. Estimated Time

### Task
Users can create and update tasks, with the following attributes:

1. Task Name
2. Project ID (to associate tasks with their respective projects)

### Time Logging
Users can create, update, and delete logs. Each log entry contains:

1. Task ID (to link the log entry to a specific task)
2. User ID (obtained from authentication to track the user responsible for the log)
3. End Time
4. Start Time

## Technical Details
This project is built using Laravel and follows the Repository Pattern to abstract and decouple the model and database layers. Each module has its own interface and repository, allowing for flexible dependency injection within the controllers.

## Setup Guide

### Clone the Repository
```bash
git clone https://github.com/murtazapervez/siochallenge
cd /path/to/project_folder
composer update


## Setting Up the Database

1. Create a database in your preferred database platform.
2. Update the following details in the `.env` file to connect to your database.
3. Once the `.env` file is updated, run `php artisan migrate`.

## Running the Application

You can use XAMPP, NGINX, or your preferred web server to run the application, or use Laravel's built-in server:

php artisan serve

## Accessing the Application

You can access the application using either of the following URLs:

- [http://127.0.0.1:8000](http://127.0.0.1:8000)
- [http://localhost:8000](http://localhost:8000)

## Future Possibilities

In the future, we plan to implement the following enhancements:

- Assigning projects to different users.
- Implementing a ticketing system for enhanced functionality.


