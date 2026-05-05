# Laravel User Management System (CRUD + API + Frontend)

This project is a simple **User Management System** built using Laravel. It includes a RESTful API and a Blade-based frontend for managing users.

---

## 🚀 Features

- Create user (name, email, phone number, password, status)
- View users with pagination support
- Filter users by status (active / inactive)
- Update user details (email & phone number unique)
- Soft delete users
- Bulk delete users
- Export users (API ready endpoint)
- RESTful API (JSON responses)
- Frontend UI using Blade + JavaScript (Fetch API)

---

## 🛠️ Tech Stack

- Laravel
- PHP 8+
- MySQL
- Blade Template Engine
- JavaScript (Fetch API)
- HTML / CSS

---

## ⚙️ Installation Steps

### 1. Clone Repository
```bash
git clone https://github.com/your-username/laravel-user-crud.git
cd laravel-user-crud
```
### 2. Install Dependencies
```
composer install
```
### 3. Environment Setup
```
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database (MySQL)
```
Update .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```
### 5. Run Migrations
```php artisan migrate```

### 6. Start Server
```
php artisan serve
```

### 🌐 Application Access
```
Frontend UI
http://127.0.0.1:8000/users
API Base URL
http://127.0.0.1:8000/api/users
```

### 📌 API Endpoints
```
Method	Endpoint	Description
GET	/api/users	Get all users
POST	/api/users	Create user
GET	/api/users/{id}	Get single user
PUT	/api/users/{id}	Update user
DELETE	/api/users/{id}	Delete user
DELETE	/api/users	Bulk delete
```
### 📊 Database Fields
```
id
name
email
phone_number
password
status (active / inactive)
email_verified_at
remember_token
created_at
updated_at
deleted_at (soft delete)
```

### 🔐 Security Features
```
Password hashing (bcrypt)
CSRF protection
Input validation
Unique email & phone number
Soft delete support
```

### 🧠 Notes
```
API returns JSON format
Frontend uses Fetch API
Laravel MVC architecture followed
Clean separation of routes (web.php & api.php)
```
