# SalesPulse Analytics — Git Repository Structure

## 📁 Repository File Tree

```
sales_dashboard/                     ← Git root
│
├── .git/                            ← Git internal (auto-created, never touch)
├── .gitignore                       ← Files excluded from Git ✅
│
├── README.md                        ← Project docs & setup guide
├── START_PROJECT.bat                ← Windows launcher
│
├── config/
│   ├── app.php                      ← Autoloader, session, constants ✅
│   ├── database.php                 ← ❌ IGNORED (has real credentials)
│   └── database.example.php        ← ✅ TRACKED (template, no real passwords)
│
├── database/
│   └── schema.sql                   ← ✅ DB schema + sample data
│
├── app/
│   ├── controllers/
│   │   ├── DashboardController.php  ✅
│   │   ├── SalesController.php      ✅
│   │   ├── ProductsController.php   ✅
│   │   └── CustomersController.php  ✅
│   │
│   ├── models/
│   │   ├── DashboardModel.php       ✅
│   │   ├── SalesModel.php           ✅
│   │   ├── ProductsModel.php        ✅
│   │   └── CustomersModel.php       ✅
│   │
│   └── views/
│       ├── layouts/
│       │   ├── header.php           ✅
│       │   └── footer.php           ✅
│       ├── dashboard/
│       │   └── index.php            ✅
│       ├── sales/
│       │   └── index.php            ✅
│       ├── products/
│       │   └── index.php            ✅
│       └── customers/
│           └── index.php            ✅
│
├── public/
│   ├── index.php                    ← Front Controller ✅
│   ├── .htaccess                    ← URL rewriting ✅
│   ├── css/
│   │   └── style.css                ✅
│   ├── js/
│   │   └── app.js                   ✅
│   └── uploads/
│       └── .gitkeep                 ← Keeps folder in Git, files ignored ✅
│
└── logs/
    └── .gitkeep                     ← Keeps folder in Git, logs ignored ✅
```

---

## 🚀 Git Setup & Workflow

### Initialize Repository (First Time)
```bash
cd sales_dashboard
git init
git add .
git commit -m "Initial commit: SalesPulse Analytics Dashboard"
```

### Connect to GitHub
```bash
git remote add origin https://github.com/yourusername/sales-dashboard.git
git branch -M main
git push -u origin main
```

### Daily Workflow
```bash
# Check what changed
git status

# Add changes
git add .

# Commit with message
git commit -m "feat: add customer export feature"

# Push to GitHub
git push
```

---

## 🌿 Recommended Branch Strategy

```
main          ← Production-ready code only
  └── develop ← Active development
        ├── feature/export-pdf
        ├── feature/user-auth
        └── fix/chart-bug
```

```bash
# Create new feature branch
git checkout -b feature/export-pdf

# Merge back to develop when done
git checkout develop
git merge feature/export-pdf

# Delete feature branch after merge
git branch -d feature/export-pdf
```

---

## 🔐 Security Rules (What NOT to Push)

| File                    | Why Ignored                        |
|-------------------------|------------------------------------|
| `config/database.php`   | Contains DB username & password    |
| `*.log`                 | May contain sensitive error info   |
| `public/uploads/`       | User-uploaded files, not code      |
| `.env`                  | Environment secrets                |

> ✅ Always use `config/database.example.php` as the template.
> New developers copy it → rename to `database.php` → fill in their credentials.

---

## 👥 For New Developers (Clone & Setup)

```bash
# 1. Clone the repo
git clone https://github.com/yourusername/sales-dashboard.git
cd sales-dashboard

# 2. Create your database config
cp config/database.example.php config/database.php
# Edit database.php with your credentials

# 3. Import the database
mysql -u root -p < database/schema.sql

# 4. Run on XAMPP or PHP built-in server
php -S localhost:8000 -t public/
```

---

## 📝 Commit Message Convention

```
feat:     New feature           → feat: add sales export to CSV
fix:      Bug fix               → fix: chart not loading on mobile
style:    CSS/UI changes        → style: update sidebar colors
refactor: Code restructure      → refactor: move query to model
docs:     Documentation         → docs: update README setup steps
db:       Database changes      → db: add index to sales table
```
