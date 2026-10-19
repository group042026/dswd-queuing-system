# 🏛️ DSWD Queuing System

A modern, secure, and real-time Queuing and Client Transaction Management System built for the **Department of Social Welfare and Development (DSWD)**. The application handles end-to-end client queuing, role-based workflows (Admin, Receptionist, Social Worker, Approving Officer, Cashier/Paymaster), and real-time live monitor updates using **Laravel 12**, **Laravel Reverb (WebSockets)**, **Alpine.js**, and **Tailwind CSS**.

---

## 📋 Table of Contents
1. [System Requirements](#-system-requirements)
2. [Quick Start (One-Liner)](#-quick-start-one-liner)
3. [Step-by-Step Setup Guide](#-step-by-step-setup-guide)
   - [1. Clone / Navigate to Directory](#1-navigate-to-project-directory)
   - [2. Install Dependencies](#2-install-dependencies)
   - [3. Configure Environment Variables (`.env`)](#3-configure-environment-variables-env)
   - [4. Generate Application Key](#4-generate-application-key)
   - [5. Setup Database & Run Migrations](#5-setup-database--run-migrations)
   - [6. Build Frontend Assets](#6-build-frontend-assets)
4. [Running the Application](#-running-the-application)
   - [Option A: Concurrent Dev Server (Recommended)](#option-a-concurrent-dev-server-recommended)
   - [Option B: Running Services Individually](#option-b-running-services-individually)
5. [Default User Accounts & Roles](#-default-user-accounts--roles)
6. [Real-time WebSocket Setup (Laravel Reverb)](#-real-time-websocket-setup-laravel-reverb)
7. [Production Deployment Checklist](#-production-deployment-checklist)
8. [Troubleshooting & Common Fixes](#-troubleshooting--common-fixes)

---

## 💻 System Requirements

Before running the project, verify that your local environment has:

| Requirement | Minimum Version | Notes |
| :--- | :--- | :--- |
| **PHP** | `>= 8.2` | With extensions: `bcmath`, `curl`, `mbstring`, `openssl`, `pdo_sqlite` or `pdo_mysql`, `tokenizer`, `xml`, `zip` |
| **Composer** | `>= 2.2` | PHP dependency manager |
| **Node.js** | `>= 18.x` | With `npm` |
| **Database** | SQLite or MySQL 8+ | SQLite is pre-configured by default |

---

## ⚡ Quick Start (One-Liner)

If you already have Composer and Node.js installed:

```bash
composer run setup
composer run dev
```

> **Note:** The `setup` script will install dependencies, generate `.env` if missing, generate the app key, run migrations, and compile production assets.

---

## 🛠️ Step-by-Step Setup Guide

### 1. Navigate to Project Directory
```bash
cd /path/to/dswd-queuing-system
```

### 2. Install Dependencies

#### Install PHP Packages (Composer):
```bash
composer install
```

#### Install JavaScript Packages (NPM):
```bash
npm install
```

---

### 3. Configure Environment Variables (`.env`)

Create your `.env` configuration file by duplicating `.env.example`:

```bash
cp .env.example .env
```

Open `.env` in your text editor and customize the following settings:

```ini
APP_NAME="DSWD Queuing System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# --------------------------------------------------------------------------
# Database Configuration (Default: SQLite)
# --------------------------------------------------------------------------
DB_CONNECTION=sqlite
# For SQLite, the database file will reside in database/database.sqlite

# If you prefer MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=dswd_queuing_db
# DB_USERNAME=root
# DB_PASSWORD=your_password

# --------------------------------------------------------------------------
# Session, Cache, and Queue
# --------------------------------------------------------------------------
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
CACHE_STORE=database
QUEUE_CONNECTION=database

# --------------------------------------------------------------------------
# Real-time WebSocket (Laravel Reverb) Configuration
# --------------------------------------------------------------------------
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=451339
REVERB_APP_KEY=cv8nygahwweeappipwoo
REVERB_APP_SECRET=cltrticteesggfyhhpll
REVERB_HOST="localhost"
REVERB_SERVER_HOST="0.0.0.0"
REVERB_PORT=8080
REVERB_SCHEME=http

# Vite Frontend Reverb Variables
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"

# --------------------------------------------------------------------------
# Initial Admin Credentials (Used by Seeder)
# --------------------------------------------------------------------------
INITIAL_ADMIN_EMAIL=admin@dswd.gov.ph
INITIAL_ADMIN_PASSWORD=Password123!
```

> 💡 **Tip:** If testing across a local area network (LAN) from other devices or tablets, replace `REVERB_HOST="localhost"` with your machine's local IP (e.g. `192.168.1.85`).

---

### 4. Generate Application Key

Generate the cryptographic application encryption key:

```bash
php artisan key:generate
```

---

### 5. Setup Database & Run Migrations

#### For SQLite:
Create the database file if it does not exist:
```bash
touch database/database.sqlite
```

#### Run Database Migrations:
```bash
php artisan migrate
```

#### Seed Initial Database Roles & Admin Account:
Run the seeders to populate system roles and create the initial administrator:
```bash
php artisan db:seed
```

Or run fresh migrations with seeders:
```bash
php artisan migrate:fresh --seed
```

#### Create the Public Storage Symlink:
Ensure uploaded client requirements and photos are publicly accessible:
```bash
php artisan storage:link
```

---

### 6. Build Frontend Assets

Compile Tailwind CSS and JavaScript assets:

```bash
# For local development with live hot-reloading:
npm run dev

# Or build optimized static production bundles:
npm run build
```

---

## 🚀 Running the Application

### Option A: Concurrent Dev Server (Recommended)

Run all required background services concurrently with a single command:

```bash
composer run dev
```

This starts:
- 🌐 **Web Server**: `http://localhost:8000` (or `http://0.0.0.0:8000`)
- ⚙️ **Queue Worker**: Listens for background tasks & notifications
- ⚡ **Vite Dev Server**: Live CSS/JS compiler with HMR
- 📡 **Laravel Reverb**: Real-time WebSocket server on port `8080`

---

### Option B: Running Services Individually

If you prefer dedicated terminal tabs or production process managers:

1. **Terminal 1: Laravel Web Application**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

2. **Terminal 2: Laravel Reverb WebSockets**
   ```bash
   php artisan reverb:start --host=0.0.0.0 --port=8080
   ```

3. **Terminal 3: Database Queue Worker**
   ```bash
   php artisan queue:work --tries=3
   ```

4. **Terminal 4: Vite Asset Compiler**
   ```bash
   npm run dev
   ```

---

## 👥 Default User Accounts & Roles

The system operates on strict role-based redirects and permissions:

| Role | Default Email | Default Password | Primary Dashboard |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@dswd.gov.ph` | Set in `.env` (`INITIAL_ADMIN_PASSWORD`) | `/admin/dashboard` |
| **Receptionist** | `receptionist@dswd.gov.ph` | Set during creation | `/receptionist/dashboard` |
| **Social Worker** | `socialworker@dswd.gov.ph` | Set during creation | `/social-worker/dashboard` |
| **Approving Officer** | `approver@dswd.gov.ph` | Set during creation | `/approving-officer/dashboard` |
| **Cashier / Paymaster**| `cashier@dswd.gov.ph` | Set during creation | `/cashier/dashboard` |

> 🔑 **Creating New Users**: Log into `/admin/dashboard` ➔ Navigate to **User List** ➔ Click **Add User** to create staff accounts with specific assigned roles.

---

## 📡 Real-time WebSocket Setup (Laravel Reverb)

Real-time queuing notifications (e.g. queue tickets advancing, client status updates, live dashboard metrics) use Laravel Reverb.

### Verifying Reverb Connectivity:
1. Ensure `BROADCAST_CONNECTION=reverb` in your `.env`.
2. Ensure the Reverb daemon is running:
   ```bash
   php artisan reverb:start --debug
   ```
3. Open your browser developer console (`F12` ➔ **Console**). You should see:
   ```
   [Echo] Connecting to Reverb... Connected.
   ```

---

## 🔒 Security Hardening

The application features enterprise-grade security middleware configured in `app/Http/Middleware/SecurityHeaders.php`:

- **Content Security Policy (CSP)**: Mitigates XSS and unauthorized script injection.
- **Subresource Integrity (SRI)**: Guarantees cryptographic integrity of external CDNs (e.g., Tesseract.js OCR).
- **Anti-Clickjacking**: `X-Frame-Options: SAMEORIGIN` and `frame-ancestors 'self'`.
- **MIME Sniffing Defense**: `X-Content-Type-Options: nosniff`.
- **HSTS**: `Strict-Transport-Security` enforced on HTTPS and production environments.
- **Cookie Security**: `HttpOnly`, `SameSite=Lax`, and conditional `Secure` flags automatically applied.
- **Cache-Control**: Sensitive administrative routes and authenticated pages enforce `no-store, no-cache`.

To execute automated security test suites:
```bash
php artisan test --filter=SecurityHeadersTest
```

---

## ❓ Troubleshooting & Common Fixes

### 1. `database.sqlite` Does Not Exist
```bash
touch database/database.sqlite
php artisan migrate --seed
```

### 2. Missing Application Key (`500 Server Error`)
```bash
php artisan key:generate
php artisan config:clear
```

### 3. Clear Stale Cached Configuration & Views
```bash
php artisan optimize:clear
```

### 4. WebSocket Connection Failed in Browser
- Check if `php artisan reverb:start` is running.
- In `.env`, ensure `REVERB_HOST` matches the domain/IP you use in your browser address bar (use `localhost` if visiting `http://localhost:8000`, or your local IP `192.168.x.x` if accessing over LAN).
- After updating `.env`, run `php artisan config:clear` and restart Vite (`npm run dev`).

### 5. Large or Deformed Navigation Icons
- Compile the latest CSS bundle: `npm run build`
- Clear your browser cache or perform a hard refresh (`Ctrl + Shift + R` or `Cmd + Shift + R`).
- Built-in defensive SVG sizing in `resources/views/layouts/sidebar.blade.php` and `navigation.blade.php` ensures standard 20px / 16px dimensions even if Vite HMR reconnects.

---

## 📜 License

This system is developed for the **Department of Social Welfare and Development (DSWD)** under internal government usage guidelines and the [MIT License](LICENSE).
