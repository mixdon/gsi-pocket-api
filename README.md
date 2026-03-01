# 🚀 GSI Pocket API

Backend REST API for **Pocket Management System**, designed to manage personal financial pockets including income, expenses, and asynchronous report generation.

---

## 📌 Overview

**GSI Pocket API** is a Laravel-based backend service that allows users to:

* Manage financial pockets
* Record incomes and expenses
* Generate financial reports asynchronously
* Export reports to Excel
* Authenticate securely using JWT

The system implements **Queue Jobs** to handle heavy processes such as report generation without blocking API responses.

---

## 🛠 Tech Stack

| Technology        | Description               |
| ----------------- | ------------------------- |
| **Laravel 12**    | Backend Framework         |
| **PHP 8.3**       | Server-side Language      |
| **PostgreSQL**    | Database                  |
| **JWT Auth**      | Authentication System     |
| **Laravel Queue** | Background Job Processing |
| **Laravel Excel** | Report Export (.xlsx)     |

---

## ⚙️ Features

✅ JWT Authentication
✅ Pocket Management
✅ Income & Expense Tracking
✅ Async Report Generation (Queue Job)
✅ Excel Report Export
✅ RESTful API Architecture

---

## 📂 Project Structure

```
app/
 ├── Http/Controllers
 ├── Jobs
 ├── Models
 ├── Exports
routes/
 ├── api.php
 └── web.php
```

---

## 🚀 Installation & Setup

### 1️⃣ Clone Repository

```bash
git clone https://github.com/your-username/gsi-pocket-api.git
cd gsi-pocket-api
```

---

### 2️⃣ Install Dependencies

```bash
composer install
```

---

### 3️⃣ Environment Configuration

```bash
cp .env.example .env
```

Configure database connection inside `.env`.

---

### 4️⃣ Generate Application Key

```bash
php artisan key:generate
```

---

### 5️⃣ Generate JWT Secret

```bash
php artisan jwt:secret
```

---

### 6️⃣ Run Migration & Seeder

```bash
php artisan migrate --seed
```

---

### 7️⃣ Create Storage Link

```bash
php artisan storage:link
```

---

### 8️⃣ Start Queue Worker

Required for async report generation:

```bash
php artisan queue:work
```

---

### 9️⃣ Run Development Server

```bash
php artisan serve
```

Application will run at:

```
http://127.0.0.1:8000
```

---

## 🔄 Queue System

Report exports are processed using Laravel Queue Jobs.

Flow:

```
Request Report
      ↓
Job Dispatched
      ↓
Queue Worker Process
      ↓
Excel File Generated
      ↓
Download Available
```

---

## 🔐 Authentication

Authentication uses **JWT Token**.

Example login flow:

```
POST /api/auth/login
↓
Receive Token
↓
Authorize using Bearer Token
```

---

## 📊 Report Export

Users can generate pocket reports in Excel format asynchronously.

Generated files are stored in:

```
storage/app/public/reports
```

Download endpoint:

```
GET /reports/{filename}
```

---

## 🧪 Running Queue Worker (Recommended)

Keep queue running during development:

```bash
php artisan queue:work --queue=reports
```

---

## 📎 API Base URL

```
/api
```

Example endpoints:

| Method | Endpoint                    | Description     |
| ------ | --------------------------- | --------------- |
| POST   | /auth/login                 | User Login      |
| GET    | /auth/profile               | User Profile    |
| POST   | /pockets                    | Create Pocket   |
| POST   | /incomes                    | Add Income      |
| POST   | /expenses                   | Add Expense     |
| POST   | /pockets/{id}/create-report | Generate Report |

---

## 👨‍💻 Author

Developed by **Doni Kurniawan**

---

## 📄 License

This project is open-source and available under the MIT License.
