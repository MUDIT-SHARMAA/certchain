# ⛓ CertChain — Blockchain Certificate System
### Complete Setup Guide

---

## 📋 Requirements

| Requirement | Version |
|---|---|
| PHP | 8.2 or higher |
| Composer | 2.x |
| MySQL | 8.0 or higher |
| Node.js (optional) | 18+ |
| Laravel | 11.x |

---

## 🚀 Step-by-Step Installation

### Step 1 — Copy Project Files
Place the `certchain` folder in your web server's root (e.g., `htdocs` for XAMPP or `www` for WAMP).

### Step 2 — Install PHP Dependencies
Open terminal inside the `certchain` folder and run:
```bash
composer install
```

### Step 3 — Create Environment File
```bash
cp .env.example .env
php artisan key:generate
```

### Step 4 — Configure Database
Open `.env` and update these lines:
```env
DB_DATABASE=certchain
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

Then create the database in MySQL:
```sql
CREATE DATABASE certchain CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 5 — Configure College Info
In `.env`, set your college name:
```env
COLLEGE_NAME="Shri Vaishnav Institute of Technology"
APP_URL=http://localhost/certchain/public
```

### Step 6 — Configure Email (Gmail)
In `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourcollege@gmail.com
MAIL_PASSWORD=your_app_password   # Google App Password (not regular password)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=yourcollege@gmail.com
MAIL_FROM_NAME="CertChain - College Name"
```

> 💡 To get a Gmail App Password:
> Google Account → Security → 2-Step Verification → App Passwords → Generate

### Step 7 — Run Migrations & Seed
```bash
php artisan migrate --seed
```

This will create all tables and seed:
- ✅ Default admin account
- ✅ Sample HOD and Faculty accounts
- ✅ Two certificate templates (Participation + Achievement)

### Step 8 — Create Storage Link
```bash
php artisan storage:link
```
This links `storage/app/public` to `public/storage` (needed for PDFs, QR codes).

### Step 9 — Start the Server
```bash
php artisan serve
```
Visit: **http://localhost:8000**

---

## 🔐 Default Login Credentials

| Role | Email | Password |
|---|---|---|
| **Admin** | admin@college.edu | Admin@1234 |
| **HOD** | hod.cs@college.edu | Hod@1234 |
| **Faculty** | faculty@college.edu | Faculty@1234 |

> ⚠️ Change all passwords after first login!

---

## 📁 Project Structure

```
certchain/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── AdminController.php      ← Admin dashboard, users
│   │   │   └── TemplateController.php   ← Certificate templates
│   │   ├── AuthController.php           ← Login/logout
│   │   ├── CertificateController.php    ← Issue, bulk, download
│   │   ├── EventController.php          ← Events CRUD
│   │   ├── FacultyController.php        ← Faculty dashboard
│   │   └── VerifyController.php         ← Public verification
│   ├── Models/
│   │   ├── User.php
│   │   ├── Event.php
│   │   ├── Certificate.php
│   │   ├── CertificateTemplate.php
│   │   └── BlockchainBlock.php          ← ⛓ Core blockchain model
│   └── Services/
│       ├── BlockchainService.php        ← ⛓ Hash chain logic
│       └── CertificateService.php       ← PDF, QR, Email pipeline
├── database/
│   ├── migrations/                      ← All 6 migration files
│   └── seeders/DatabaseSeeder.php       ← Default users + templates
├── resources/views/
│   ├── layouts/app.blade.php            ← Main layout with sidebar
│   ├── auth/login.blade.php
│   ├── admin/                           ← Admin views
│   ├── faculty/                         ← Faculty views
│   ├── certificates/                    ← Issue, bulk, list, show
│   ├── verify/                          ← Public verify pages
│   └── emails/certificate.blade.php     ← Email template
└── routes/web.php                       ← All routes
```

---

## ⛓ How the Blockchain Works

```
GENESIS (0000...0000)
        ↓
Block #1: cert_hash + prev_hash → block_hash
        ↓
Block #2: cert_hash + prev_hash → block_hash
        ↓
Block #3: ...
```

Each block contains:
- `block_index` — sequential number
- `data_hash` — SHA-256 of the certificate data snapshot
- `previous_hash` — hash of the previous block
- `block_hash` — SHA-256 of (index + prev_hash + data_hash + timestamp)

**Tampering detection:** If anyone modifies a certificate in the DB, the `data_hash` won't match when recomputed → verification fails.

---

## 🎯 Key Features

### For Admin
- Create/manage Faculty, HOD, Coordinator accounts
- Create certificate templates with custom HTML
- View blockchain ledger with chain integrity check
- Full system dashboard with stats

### For Faculty / HOD / Coordinator
- Create events (Workshop, Seminar, Hackathon, etc.)
- Issue single certificates — auto blockchain-recorded
- Bulk issue certificates (fill table → issue all at once)
- Download PDF certificates
- Send certificate email to student
- Revoke certificates

### For Students / Public
- Verify certificate by **Enrollment Number** or **Certificate ID**
- See blockchain block details
- No login required for verification

---

## 🔍 Verification URL

The public verification portal is accessible at:
```
http://yoursite.com/verify
```

Each certificate QR code links to:
```
http://yoursite.com/verify/CERT-2024-XXXXXX
```

---

## 🛠 Artisan Commands

```bash
# Validate entire blockchain chain integrity
php artisan certchain:validate

# Run migrations fresh with seed
php artisan migrate:fresh --seed

# Clear caches after config changes
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## ⚡ Template Placeholders

Use these in your custom HTML certificate templates:

| Placeholder | Description |
|---|---|
| `{{student_name}}` | Student's full name |
| `{{enrollment_number}}` | Enrollment number |
| `{{student_branch}}` | Branch/Department |
| `{{student_year}}` | Year (1st, 2nd...) |
| `{{event_name}}` | Event name |
| `{{event_date}}` | Event date (formatted) |
| `{{event_type}}` | Workshop / Seminar etc. |
| `{{venue}}` | Event venue |
| `{{achievement}}` | 1st Prize / Participation etc. |
| `{{description}}` | Custom description |
| `{{issued_date}}` | Date of issuance |
| `{{issued_by}}` | Issuer's name |
| `{{issuer_designation}}` | Issuer's designation |
| `{{certificate_id}}` | Unique certificate ID |
| `{{block_hash}}` | Blockchain block hash (short) |
| `{{college_name}}` | Your college name |
| `{{{qr_code}}}` | QR code SVG (triple braces) |

---

## 🐛 Troubleshooting

**PDFs not generating?**
```bash
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

**QR codes not generating?**
```bash
composer require simplesoftwareio/simple-qrcode
```

**Storage files not accessible?**
```bash
php artisan storage:link
```

**Permission errors?**
```bash
chmod -R 775 storage bootstrap/cache
```

**Email not sending?**
- Enable 2-Step Verification on Gmail
- Create an App Password (not your regular password)
- Use the 16-character App Password in `.env`

---

## 📝 License
MIT — Free to use for educational purposes.

Built with ❤️ using Laravel 11 + Spatie Permissions + DomPDF + SimpleQrCode
