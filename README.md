# Task Management API

A RESTful API built with Laravel 10 and MySQL for managing tasks with full business rule enforcement.

## Tech Stack
- Laravel 10
- PHP 8.2+
- MySQL

---

## Live URL
```
https://task-manager-production-e7ba.up.railway.app
```

Quick test — paste this in your browser or Postman:
```
GET https://task-manager-production-e7ba.up.railway.app/api/tasks
```

---

## How To Run Locally

### Requirements
- PHP 8.2+
- Composer
- MySQL

### Steps

**1. Clone the repository**
```bash
git clone https://github.com/innocentHawi/task-manager.git
cd task-manager
```

**2. Install dependencies**
```bash
composer install
```

**3. Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure your database in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

**5. Create the database**
```sql
CREATE DATABASE task_manager;
```

**6. Run migrations and seeders**
```bash
php artisan migrate
php artisan db:seed
```

**7. Start the server**
```bash
php artisan serve
```

API is now running at `http://localhost:8000`

---

## How To Deploy (Railway)

**1.** Push your project to GitHub

**2.** Go to [railway.app](https://railway.app) and sign in with GitHub

**3.** Click **New Project** → **Deploy from GitHub repo** → select your repo

**4.** Click **New** → **Database** → **Add MySQL**

**5.** In your app service → **Variables** tab → add the following:
```env
APP_NAME=TaskManager
APP_ENV=production
APP_KEY=your_app_key
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```

**6.** Add a `Procfile` in your project root:
```
web: php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

**7.** Push changes — Railway auto-deploys on every push

**8.** Go to **Settings** → **Domains** → **Generate Domain** to get your live URL

---

## API Endpoints & Example Requests

### 1. List Tasks
```
GET /api/tasks
GET /api/tasks?status=pending
```
- Sorted by priority (high → medium → low) then due_date ascending
- Optional `status` filter: `pending`, `in_progress`, `done`

**Response:**
```json
{
    "message": "Tasks retrieved successfully",
    "data": [
        {
            "id": 1,
            "title": "Fix critical authentication bug",
            "due_date": "2026-03-30",
            "priority": "high",
            "status": "pending",
            "created_at": "2026-03-29T07:33:46.000000Z",
            "updated_at": "2026-03-29T07:33:46.000000Z"
        }
    ]
}
```

---

### 2. Create Task
```
POST /api/tasks
Content-Type: application/json
```
**Body:**
```json
{
    "title": "Fix login bug",
    "due_date": "2026-04-05",
    "priority": "high"
}
```
**Response (201):**
```json
{
    "message": "Task created successfully",
    "data": {
        "id": 1,
        "title": "Fix login bug",
        "due_date": "2026-04-05",
        "priority": "high",
        "status": "pending"
    }
}
```

**Business Rules:**
- `title` cannot duplicate a task with the same `due_date`
- `due_date` must be today or in the future
- `priority` must be `low`, `medium`, or `high`

---

### 3. Update Task Status
```
PATCH /api/tasks/{id}/status
Content-Type: application/json
```
**Body:**
```json
{
    "status": "in_progress"
}
```
**Response (200):**
```json
{
    "message": "Task status updated successfully",
    "data": {
        "id": 1,
        "status": "in_progress"
    }
}
```

**Business Rules:**
- Status can only move forward: `pending` → `in_progress` → `done`
- Cannot skip or revert status

---

### 4. Delete Task
```
DELETE /api/tasks/{id}
```
**Response (200):**
```json
{
    "message": "Task deleted successfully"
}
```

**Business Rules:**
- Only tasks with status `done` can be deleted
- Returns `403 Forbidden` otherwise

---

### 5. Daily Report (Bonus)
```
GET /api/tasks/report?date=2026-04-01
```
**Response (200):**
```json
{
    "date": "2026-04-01",
    "summary": {
        "high": {
            "pending": 2,
            "in_progress": 1,
            "done": 0
        },
        "medium": {
            "pending": 1,
            "in_progress": 0,
            "done": 3
        },
        "low": {
            "pending": 0,
            "in_progress": 0,
            "done": 1
        }
    }
}
```

---

## Database

MySQL is used. Migration files are included for easy setup.

To reset and reseed the database:
```bash
php artisan migrate:fresh --seed
```

A SQL dump file (`task_manager.sql`) is also included in the project root for direct import.
