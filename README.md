# SalesPulse Analytics Dashboard
### PHP MVC Sales Data Analytics System

---

## 📋 Project Overview

A full-featured **Sales Data Analytics Dashboard** built with **PHP (MVC Pattern)**.

| Layer      | Description                                  |
|------------|----------------------------------------------|
| Model      | Database queries via PDO (Database.php)      |
| View       | PHP templates with Chart.js visualizations   |
| Controller | Business logic, request handling, routing    |

---

## 🗂️ Project Structure

```
sales_dashboard/
├── app/
│   ├── controllers/
│   │   ├── DashboardController.php
│   │   ├── SalesController.php
│   │   ├── ProductsController.php
│   │   └── CustomersController.php
│   ├── models/
│   │   ├── DashboardModel.php
│   │   ├── SalesModel.php
│   │   ├── ProductsModel.php
│   │   └── CustomersModel.php
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│       ├── dashboard/index.php
│       ├── sales/index.php
│       ├── products/index.php
│       └── customers/index.php
├── config/
│   ├── app.php          ← Autoloader & session config
│   └── database.php     ← DB connection (PDO Singleton)
├── database/
│   └── schema.sql       ← Database schema + sample data
├── public/
│   ├── index.php        ← Front Controller (entry point)
│   ├── .htaccess        ← Clean URL routing
│   ├── css/style.css
│   └── js/app.js
└── README.md
```

---

## ⚙️ Installation & Setup

### Requirements
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.4+
- Apache with `mod_rewrite` enabled
- XAMPP / WAMP / LAMP

### Step 1 — Clone / Copy Project
```bash
# Place folder in your web root
cp -r sales_dashboard/ /xampp/htdocs/
```

### Step 2 — Import Database
```bash
# Via MySQL CLI:
mysql -u root -p < database/schema.sql

# Or via phpMyAdmin:
# Open phpMyAdmin → Import → Select database/schema.sql → Go
```

### Step 3 — Configure Database
Edit `config/database.php`:
```php
define('DB_HOST', 'localhost');   // your host
define('DB_NAME', 'sales_dashboard');
define('DB_USER', 'root');        // your username
define('DB_PASS', '');            // your password
```

### Step 4 — Configure Base URL
Edit `config/app.php`:
```php
define('BASE_URL', 'http://localhost/sales_dashboard/public');
```

Edit `public/.htaccess`:
```
RewriteBase /sales_dashboard/public/
```

### Step 5 — Open Browser
```
http://localhost/sales_dashboard/public/
```

---

## 🧩 Features

| Feature            | Details                                          |
|--------------------|--------------------------------------------------|
| KPI Dashboard      | Revenue, Orders, Customers, Avg Order Value      |
| Revenue Chart      | Line chart — last 12 months                      |
| Category Donut     | Revenue breakdown by product category            |
| Top Products       | Top 5 by revenue                                 |
| Sales Management   | View, Add, Delete with pagination                |
| Products CRUD      | Add/Delete products, low-stock alert             |
| Customers CRUD     | Add/Delete customers, total spend per customer   |
| Responsive Design  | Mobile-friendly dark theme                       |

---

## 🏗️ MVC Pattern Explained

```
Browser → public/index.php (Router)
              ↓
        Controller (e.g. DashboardController)
              ↓
         Model (DashboardModel) ↔ MySQL Database
              ↓
          View (views/dashboard/index.php)
              ↓
        Response to Browser
```

---

## 👨‍💻 Technologies Used
- **PHP 8** — Backend language
- **MySQL** — Database
- **PDO** — Secure database access (prepared statements)
- **Chart.js** — Data visualization
- **HTML5/CSS3** — Frontend
- **Apache mod_rewrite** — Clean URL routing

---

*SalesPulse Analytics — PHP Foundation & OOP Assignment*
