# Task Manager Backend API

A robust RESTful API for task management built with Laravel. This backend provides all the necessary endpoints to create, read, update, and delete tasks, with support for filtering, sorting, and pagination.



## 🔗 Live API

The API is deployed and accessible at:

**[https://task-manager-backend-vvrqh.kinsta.app/api](https://task-manager-backend-vvrqh.kinsta.app/api)**

> Note: This is an API endpoint and not meant to be accessed directly in a browser. Use API testing tools like Postman or integrate with a frontend application.

## ✨ Features

- RESTful API architecture
- CRUD operations for tasks
- Validation and error handling
- Cross-Origin Resource Sharing (CORS) enabled
- Comprehensive test suite


## 🛠️ Technologies Used

- PHP 8.1+
- Laravel 12
- MySQL Database
- PHPUnit for testing
- Laravel Eloquent ORM
- JSON API responses

## 🚀 Quick Start for Local Development

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL or compatible database
- Git

### Installation

1. Clone the repository:
 
   git clone <repository-url>
   cd task-manager-backend
 

2. Install dependencies:

   composer install

3. Create a copy of the environment file:

   cp .env.example .env
  

4. Configure your database in the `.env` file:
 
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager
   DB_USERNAME=root
   DB_PASSWORD=


5. Generate application key:
 
   php artisan key:generate
  

6. Run database migrations:

   php artisan migrate
  



8. Start the development server:
 
   php artisan serve
  

The API will be available at `http://localhost:8000/api`.

## 📝 API Documentation

### Base URL

- Local: `http://localhost:8000/api`
- Production: `https://task-manager-backend-vvrqh.kinsta.app/api`

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/tasks` | Get all tasks (with filtering, sorting, and pagination) |
| POST | `/tasks` | Create a new task |
| GET | `/tasks/{id}` | Get a specific task |
| PUT | `/tasks/{id}` | Update a task |
| DELETE | `/tasks/{id}` | Delete a task |





#### GET /api/tasks

Response:
\`\`\`json
{
  "data": [
    {
      "id": 1,
      "name": "Complete project",
      "description": "Finish the task manager project",
      "status": "Pending",
      "priority": "High",
      "due_date": "2023-06-15",
      "created_at": "2023-05-11T12:00:00.000000Z",
      "updated_at": "2023-05-11T12:00:00.000000Z"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 10,
    "total": 1,
    "last_page": 1
  }
}
\`\`\`

#### POST /api/tasks

Request:
\`\`\`json
{
  "name": "New task",
  "description": "Description of the new task",
  "status": "Pending",
  "priority": "Medium",
  "due_date": "2023-06-30"
}
\`\`\`

Response:
\`\`\`json
{
  "data": {
    "id": 2,
    "name": "New task",
    "description": "Description of the new task",
    "status": "Pending",
    "priority": "Medium",
    "due_date": "2023-06-30",
    "created_at": "2023-05-11T12:30:00.000000Z",
    "updated_at": "2023-05-11T12:30:00.000000Z"
  },
  "message": "Task created successfully"
}
\`\`\`

## 🧪 Testing

Run the test suite with:

\`\`\`bash
php artisan test
\`\`\`

The API includes both feature tests (testing API endpoints) and unit tests (testing models and controllers).

## 🔧 Deployment

### Requirements for Production

- PHP >= 8.1
- Composer
- MySQL or compatible database
- Web server (Apache/Nginx)

### Deployment Steps

1. Clone the repository on your server
2. Install dependencies: `composer install --optimize-autoloader --no-dev`
3. Configure environment variables for production
4. Generate application key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Configure your web server to point to the public directory
7. Set appropriate permissions on storage and bootstrap/cache directories


