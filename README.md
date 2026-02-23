# 🏦 ATM Cleaning Service Management System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.5+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

**Sistem manajemen komprehensif untuk koordinasi, monitoring, dan pelaporan layanan pembersihan ATM**

[Features](#-features) • [Installation](#-installation) • [User Roles](#-user-roles) • [Modules](#-modules) • [Screenshots](#-screenshots)

</div>

---

## 📑 Table of Contents

- [Overview](#-overview)
- [Key Features](#-key-features)
- [System Architecture](#-system-architecture)
- [User Roles & Permissions](#-user-roles--permissions)
- [Core Modules](#-core-modules)
- [HRIS Modules](#-hris-modules-new)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Database Schema](#-database-schema)
- [API Documentation](#-api-documentation)
- [Usage Guide](#-usage-guide)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🎯 Overview

**ATM Cleaning Service Management System** adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola operasional cleaning service ATM secara end-to-end. Sistem ini mencakup manajemen karyawan, penjadwalan, absensi real-time dengan foto wajah, pelaporan pembersihan dengan dokumentasi visual, inventory management, serta modul HRIS lengkap.

### 🌟 Why This System?

- ✅ **Real-time Monitoring** - Pantau kehadiran dan pekerjaan CS secara live
- ✅ **Photo Verification** - Absensi dengan foto wajah untuk validasi kehadiran
- ✅ **Visual Documentation** - Dokumentasi before/after pembersihan setiap ATM
- ✅ **Inventory Control** - Tracking alat dan chemical cleaning otomatis
- ✅ **HRIS Integration** - Manajemen cuti, performance review, dan jadwal kerja
- ✅ **Multi-level Approval** - Workflow approval Koordinator → Admin
- ✅ **Modern UI/UX** - Interface Gen Z aesthetic dengan responsive design
- ✅ **Scalable Architecture** - Modular design untuk easy maintenance

---

## 🚀 Key Features

### 📊 **Operational Management**

- **Area Management** - Kelola area/wilayah kerja dengan assign CS
- **ATM Management** - Database ATM dengan lokasi lengkap dan status
- **Attendance System** - Absensi digital dengan foto wajah dan GPS location
- **Work Reporting** - Laporan pembersihan dengan foto before/after/lokasi
- **Real-time Dashboard** - Monitoring live status CS dan pekerjaan

### 📦 **Inventory Management**

- **Stock Tracking** - Monitoring stok alat dan chemical real-time
- **Request System** - CS request inventory dengan approval workflow
- **Stock In/Out History** - Audit trail lengkap pergerakan inventory
- **Low Stock Alert** - Warning otomatis saat stok menipis
- **Multi-category** - Support alat (tools) dan chemical (cleaning agents)

### 👥 **HRIS Modules** (NEW!)

#### 🏖️ **Leave Management**

- **Leave Types**: Annual (6 days/year), Sick, Emergency, Unpaid
- **Leave Balance**: Auto-tracking saldo cuti per tahun
- **Multi-level Approval**: Koordinator → Admin workflow
- **Auto-reset**: Cuti tahunan reset setiap 1 Januari (no carry-over)
- **Overlap Detection**: Prevent double leave requests
- **History Tracking**: Complete audit trail

#### 📈 **Performance Review**

- **Monthly Reviews**: Review bulanan untuk setiap CS
- **4 KPI Metrics**:
    - Ketepatan Waktu (Punctuality) - Check-in 05:00-08:00
    - Kualitas Kerja (Work Quality) - Based on cleaning reports
    - Kehadiran (Attendance) - Monthly attendance rate
    - Jam Pulang (Checkout Time) - Max 17:00
- **Auto-calculation**: System auto-calculate scores from attendance data
- **Rating Scale**: 1-5 scale with detailed scoring guide
- **Dual Review**: Both Koordinator and Admin can review
- **Performance Reports**: Monthly and yearly performance tracking

#### 👔 **Employee Self-Service (ESS)**

- **Profile Management**: Update alamat, no HP, emergency contact
- **Document Upload**: KTP, KK, Ijazah, Rekening
- **Document Verification**: Admin can verify uploaded documents
- **Profile Completion**: Track profile completion percentage
- **Personal Data**: NIK, tanggal lahir, status pernikahan, bank account
- **Employment Info**: Status karyawan (Probation/Kontrak/Tetap)

#### 📅 **Shift Management**

- **Work Pattern**: 6 days work, 1 day off (rotating)
- **Monthly Schedule**: Generate schedule for entire month
- **Schedule Cycle**:
    - Day 1-21: Active schedule
    - Day 22: Book closing
    - Day 23-24: CS can request day-off
    - Day 25: Schedule published for next month
- **Auto-rotation**: Each CS gets different day off weekly
- **Request System**: CS can request preferred day off
- **Schedule Publishing**: Automatic distribution on 25th

### 🔐 **User Management & Roles**

- **3 User Roles**: Admin, Koordinator, CS
- **Role-based Access Control**: Granular permissions per role
- **User Profile**: Complete employee information
- **Activity Logging**: Track all user actions

### 📱 **Modern UI/UX**

- **Responsive Design**: Mobile-first approach (phone/tablet/desktop)
- **Gen Z Aesthetic**: Modern gradient colors and animations
- **Tailwind CSS**: Utility-first CSS framework
- **Dark Mode Ready**: (Optional feature)
- **Interactive Components**: Real-time updates and notifications

---

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     PRESENTATION LAYER                       │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │  Admin UI    │  │ Koordinator  │  │    CS UI     │      │
│  │  (Desktop)   │  │     UI       │  │  (Mobile)    │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                      BUSINESS LOGIC                          │
│  ┌─────────────────────────────────────────────────────┐    │
│  │              Laravel Controllers                     │    │
│  │  • Admin Controllers (CRUD + Approval)              │    │
│  │  • Koordinator Controllers (Review + Approval)      │    │
│  │  • CS Controllers (Self-Service)                    │    │
│  └─────────────────────────────────────────────────────┘    │
│  ┌─────────────────────────────────────────────────────┐    │
│  │              Service Layer (Optional)                │    │
│  │  • Leave Approval Service                           │    │
│  │  • Shift Generator Service                          │    │
│  │  • Performance Calculation Service                  │    │
│  └─────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                       DATA LAYER                             │
│  ┌─────────────────────────────────────────────────────┐    │
│  │           Eloquent Models & Relationships            │    │
│  └─────────────────────────────────────────────────────┘    │
│  ┌─────────────────────────────────────────────────────┐    │
│  │                  MySQL Database                      │    │
│  │  • 22 Tables (Core + HRIS)                          │    │
│  │  • Foreign Keys & Constraints                        │    │
│  │  • Indexes for Performance                           │    │
│  └─────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

---

## 👥 User Roles & Permissions

### 🔴 **Admin** (Full Access)

**Core Functions:**

- ✅ Manage all users (CS, Koordinator)
- ✅ Manage areas and ATM locations
- ✅ View all attendance records
- ✅ View all work reports
- ✅ Manage inventory (CRUD)
- ✅ Approve/reject inventory requests (final approval)
- ✅ Generate reports and analytics

**HRIS Functions:**

- ✅ Final approval for leave requests
- ✅ Create and submit performance reviews
- ✅ View all employee documents
- ✅ Generate and publish monthly schedules
- ✅ Approve/reject shift requests
- ✅ Manage attendance rules and KPI templates

### 🟡 **Koordinator** (Supervisor)

**Core Functions:**

- ✅ View team attendance
- ✅ View team work reports
- ✅ First-level approval for inventory requests
- ✅ Monitor team performance

**HRIS Functions:**

- ✅ First-level approval for leave requests
- ✅ Create initial performance reviews for team
- ✅ View team schedules
- ✅ Approve/reject shift requests

### 🟢 **CS (Cleaning Service)** (Field Worker)

**Core Functions:**

- ✅ Clock in/out with photo attendance
- ✅ Submit work reports with photos (before/after/location)
- ✅ Request inventory items
- ✅ View assigned area and ATM list
- ✅ View own attendance history

**HRIS Functions:**

- ✅ Submit leave requests
- ✅ View leave balance and history
- ✅ View own performance reviews
- ✅ Update personal profile (ESS)
- ✅ Upload personal documents
- ✅ View monthly work schedule
- ✅ Request day-off (during request period)

---

## 📦 Core Modules

### 1. 👤 **User Management**

```php
• CRUD users with roles (Admin/Koordinator/CS)
• Profile management with photo upload
• Role-based access control (RBAC)
• Password reset functionality
```

### 2. 📍 **Area Management**

```php
• Create/Read/Update/Delete areas
• Assign multiple CS to an area
• Track CS coverage per area
• Area-based reporting
```

### 3. 🏧 **ATM Management**

```php
• Comprehensive ATM database
• Location mapping (GPS coordinates ready)
• Status tracking (Active/Inactive)
• Area assignment
• Detailed address information
```

### 4. ⏰ **Attendance System**

```php
• Check-in with mandatory photo (face verification ready)
• GPS location capture
• Status: Hadir/Izin/Sakit
• Time tracking (05:00 - 08:00 recommended)
• Notes/keterangan field
• Filtering by date/CS/area/status
```

### 5. 📝 **Work Reporting**

```php
• Before/After/Location photo documentation
• Timestamp tracking
• Notes for issues/obstacles
• Linked to attendance record
• Filtering and search
```

### 6. 📦 **Inventory Management**

```php
• Item categorization (Alat/Chemical)
• Stock tracking with units (pcs/liter/kg/etc)
• Low stock warnings (customizable threshold)
• Stock movement history (in/out)
• Notes for each transaction
```

### 7. 🛒 **Inventory Request System**

```php
• CS submit requests with quantity
• Multi-level approval workflow:
  1. Koordinator approval
  2. Admin final approval
• Auto stock deduction on approval
• Request history tracking
• Status: Pending/Approved/Rejected
```

---

## 🆕 HRIS Modules (New!)

### 1. 🏖️ **Leave Management**

**Database Tables:**

- `leave_quotas` - Track leave balance per CS per year
- `leave_requests` - Leave applications with approval workflow
- `leave_balance_history` - Audit trail of balance changes

**Features:**

```php
• Leave Types:
  - Annual: 6 days/year (cannot carry-over)
  - Sick: Unlimited (with medical certificate)
  - Emergency: Unlimited (valid reason required)
  - Unpaid: Unlimited

• Workflow:
  1. CS submits leave request
  2. Koordinator reviews → Approve/Reject
  3. Admin final review → Approve/Reject
  4. Auto-deduct from balance on approval

• Balance Management:
  - Auto-create quota at start of year
  - Real-time balance tracking
  - History of all transactions
  - Automatic yearly reset (Jan 1st)

• Validations:
  - Check sufficient balance (annual leave)
  - Detect overlapping leave dates
  - Prevent past date requests
```

**Key Models:**

- `LeaveQuota` - Balance tracking with helpers
- `LeaveRequest` - Request with approval methods
- `LeaveBalanceHistory` - Audit trail

### 2. 📈 **Performance Review**

**Database Tables:**

- `performance_reviews` - Monthly review records
- `performance_kpi_templates` - KPI definitions and scoring guides
- `attendance_rules` - Rules for check-in/out scoring

**4 KPI Metrics:**

```php
1. Ketepatan Waktu (Punctuality) - Weight: 25%
   • Check-in window: 05:00 - 08:00
   • Auto-score based on late count
   • Scale: 5 (never late) to 1 (always late)

2. Kualitas Kerja (Work Quality) - Weight: 30%
   • Based on work report quality
   • Photo documentation completeness
   • Manual scoring by Koordinator/Admin
   • Scale: 5 (excellent) to 1 (poor)

3. Kehadiran (Attendance) - Weight: 25%
   • Auto-calculate from attendance records
   • Monthly attendance rate
   • Scale: 5 (perfect) to 1 (many absences)

4. Jam Pulang (Checkout Time) - Weight: 20%
   • Maximum checkout: 17:00
   • Auto-score based on late checkout count
   • Scale: 5 (always on time) to 1 (always late)
```

**Review Process:**

```php
1. Auto-generate review template monthly
2. Koordinator inputs scores + notes
3. Admin reviews + adds final notes
4. System calculates:
   - Total score (4-20)
   - Average score (1.00-5.00)
   - Rating (Sangat Baik/Baik/Cukup/Kurang)
5. CS can view completed reviews
```

**Key Features:**

- Auto-calculation from attendance data
- Dual review (Koordinator + Admin)
- Historical performance tracking
- Improvement plan suggestions
- Achievement highlights

### 3. 👔 **Employee Self-Service (ESS)**

**Updated Table:**

- `cs_profiles` - Extended with 16 new fields

**New Fields:**

```php
Personal Information:
• Alamat lengkap
• No. HP & WhatsApp
• NIK (KTP number)
• No. KK (Family card)
• Tanggal & tempat lahir
• Jenis kelamin (L/P)
• Status pernikahan

Emergency Contact:
• Name
• Phone number
• Relationship

Bank Information:
• Bank name
• Account number
• Account holder name

Employment:
• Tanggal bergabung
• Status (Probation/Kontrak/Tetap)
```

**Document Management:**

```php
• Required Documents:
  - KTP (ID Card)
  - KK (Family Card)
  - Ijazah (Education Certificate)
  - Rekening (Bank Account)

• Upload Features:
  - File type validation (jpg/png/pdf)
  - File size limit
  - Secure storage
  - Admin verification workflow

• Document Status:
  - Uploaded
  - Verified (by Admin)
  - Rejected (with reason)
```

**Profile Completion:**

- Track completion percentage
- Highlight missing information
- Remind incomplete profiles

### 4. 📅 **Shift Management**

**Database Tables:**

- `shift_schedules` - Monthly work schedules
- `shift_requests` - CS day-off requests
- `attendance_rules` - Shift rules configuration

**Schedule Pattern:**

```php
• Work Pattern: 6 days work / 1 day off
• Shift Hours: 08:00 - 17:00
• Rotation: Each CS gets different day off weekly
• Monthly Generation: Auto-generate for entire month
```

**Schedule Cycle (Monthly):**

```
Day 1-21:  Active Schedule
           └─ CS work according to schedule

Day 22:    Book Closing
           └─ Finalize current month

Day 23-24: Request Period
           └─ CS can request preferred day off for next month

Day 25:    Schedule Published
           └─ Admin publishes next month schedule
           └─ CS receives notification

Day 26-31: Preparation Period
           └─ CS review upcoming schedule
```

**Request System:**

```php
• Request Window: Only 23rd-24th each month
• CS can request specific date for day off
• Admin reviews all requests
• Conflict resolution by Admin
• Approved requests auto-update schedule
• Rejected requests stay with default rotation
```

**Schedule Features:**

- Auto-rotation algorithm
- Fairness distribution (each CS gets equal days off)
- Request approval/rejection
- Schedule modification (before publish)
- Notification system (email/in-app)
- Schedule history tracking

**Schedule Status:**

- Scheduled: Initial state
- Worked: CS completed work
- Absent: CS didn't show up
- Leave: CS on approved leave

---

## 🛠️ Tech Stack

### **Backend**

- **Framework**: Laravel 11.x
- **Language**: PHP 8.5+
- **Database**: MySQL 8.0+
- **ORM**: Eloquent
- **Authentication**: Laravel Breeze

### **Frontend**

- **CSS Framework**: Tailwind CSS 3.x
- **Template Engine**: Blade
- **JavaScript**: Vanilla JS (minimal, progressive enhancement)
- **Icons**: Heroicons + Custom SVG
- **Responsive**: Mobile-first design

### **Development Tools**

- **Package Manager**: Composer
- **Build Tool**: Vite
- **Version Control**: Git
- **Environment**: MAMP/XAMPP/Laravel Valet

### **Storage**

- **File Storage**: Laravel Storage (local/S3-ready)
- **Photos**: Public disk (attendance, reports, documents)
- **Cache**: Database/Redis (configurable)

---

## 💻 Requirements

### **Server Requirements**

```
PHP >= 8.5
MySQL >= 8.0
Apache/Nginx
Composer 2.x
Node.js 18+ & NPM (for asset compilation)
```

### **PHP Extensions**

```
BCMath
Ctype
Fileinfo
JSON
Mbstring
OpenSSL
PDO
Tokenizer
XML
GD or Imagick (for image processing)
```

### **Recommended**

```
RAM: 2GB minimum
Storage: 10GB+ (for photos)
SSL Certificate (for production)
```

---

## 📥 Installation

### **1. Clone Repository**

```bash
git clone https://github.com/your-username/cleaning-service-atm.git
cd cleaning-service-atm
```

### **2. Install Dependencies**

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### **3. Environment Setup**

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306 (or 8889 for MAMP)
DB_DATABASE=cleaning_service_atm
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **4. Database Setup**

```bash
# Create database
mysql -u root -p
CREATE DATABASE cleaning_service_atm;
exit

# Run migrations
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed
```

### **5. Storage Setup**

```bash
# Create storage symlink
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### **6. Compile Assets**

```bash
# Development
npm run dev

# Production
npm run build
```

### **7. Start Development Server**

```bash
# Option 1: Laravel built-in server
php artisan serve

# Option 2: Use MAMP/XAMPP
# Point to /public directory
```

### **8. Access Application**

```
URL: http://localhost:8000 (or your MAMP URL)

Default Accounts:
Admin:
  Email: admin@example.com
  Password: password

Koordinator:
  Email: koordinator@example.com
  Password: password

CS:
  Email: cs@example.com
  Password: password
```

---

## 🗄️ Database Schema

### **Core Tables (12 tables)**

```
users                          # User authentication
cs_profiles                    # CS extended profile (updated with HRIS fields)
areas                          # Work areas
cs_area                        # CS-Area pivot
atms                           # ATM locations
absensis                       # Attendance records
laporan_atms                   # Work reports
inventories                    # Inventory items
inventory_logs                 # Stock movements
permintaan_inventories         # Inventory requests
cache                          # Application cache
jobs                           # Queue jobs
```

### **HRIS Tables (10 new tables)**

```
leave_quotas                   # Leave balance tracking
leave_requests                 # Leave applications
leave_balance_history          # Leave audit trail
performance_reviews            # Monthly reviews
performance_kpi_templates      # KPI definitions
employee_documents             # Document uploads
shift_schedules                # Monthly work schedules
shift_requests                 # Day-off requests
attendance_rules               # Check-in/out rules
```

### **Key Relationships**

```
User (1) ──── (1) CsProfile
CsProfile (N) ──── (N) Area [cs_area]
Area (1) ──── (N) Atm
CsProfile (1) ──── (N) Absensi
CsProfile (1) ──── (N) LaporanAtm
Inventory (1) ──── (N) InventoryLog
Inventory (1) ──── (N) PermintaanInventory

# HRIS Relationships
CsProfile (1) ──── (N) LeaveQuota
CsProfile (1) ──── (N) LeaveRequest
CsProfile (1) ──── (N) PerformanceReview
CsProfile (1) ──── (N) EmployeeDocument
CsProfile (1) ──── (N) ShiftSchedule
CsProfile (1) ──── (N) ShiftRequest
```

### **Entity Relationship Diagram**

```
[View full ERD diagram in /docs/database-schema.png]
```

---

## 📡 API Documentation

### **API Endpoints** (If API feature enabled)

#### Authentication

```
POST   /api/login              # User login
POST   /api/logout             # User logout
POST   /api/register           # User registration (admin only)
```

#### Attendance

```
GET    /api/attendance         # List attendance
POST   /api/attendance         # Clock in
PUT    /api/attendance/{id}    # Update attendance
```

#### Work Reports

```
GET    /api/reports            # List reports
POST   /api/reports            # Submit report
GET    /api/reports/{id}       # View report details
```

#### Inventory

```
GET    /api/inventory          # List items
POST   /api/inventory/request  # Submit request
```

#### HRIS - Leave

```
GET    /api/leave/balance      # Get leave balance
POST   /api/leave/request      # Submit leave request
GET    /api/leave/requests     # List my requests
PUT    /api/leave/approve/{id} # Approve leave (Koordinator/Admin)
```

#### HRIS - Performance

```
GET    /api/performance        # Get my reviews
GET    /api/performance/{id}   # View specific review
```

#### HRIS - Shift

```
GET    /api/shift/schedule     # Get my schedule
POST   /api/shift/request      # Request day off
```

[Full API documentation available in /docs/api-documentation.md]

---

## 📱 Usage Guide

### **For Admin**

#### 1. Dashboard

- View summary: Total CS, Areas, ATMs, Today's attendance
- Quick stats: Pending requests, low stock items
- Recent activity feed

#### 2. Manage CS

```
1. Navigate to Team CS menu
2. Click "Tambah CS Baru"
3. Fill form: Name, Email, Password, Area
4. Upload photo (optional)
5. Save
```

#### 3. Manage Inventory

```
1. Go to Inventory menu
2. View current stock levels
3. Click "Kelola Stok" on item
4. Add stock (with notes) OR Reduce stock
5. View history in "Riwayat Stok"
```

#### 4. Approve Inventory Requests

```
1. Go to Permintaan menu
2. View pending requests
3. Review details and Koordinator notes
4. Approve or Reject with notes
5. Stock auto-deducted on approval
```

#### 5. HRIS - Approve Leave

```
1. Go to HRIS → Leave Management
2. View pending leave requests
3. Check leave balance and dates
4. Review Koordinator approval
5. Final approve/reject with notes
6. Balance auto-updated
```

#### 6. HRIS - Performance Review

```
1. Go to HRIS → Performance Review
2. Select month and CS
3. Review Koordinator's scores
4. Add Admin scores/notes
5. Submit final review
6. CS can view completed review
```

#### 7. HRIS - Generate Schedule

```
1. Go to HRIS → Shift Management
2. Select target month
3. Review day-off requests (23-24)
4. Click "Generate Schedule"
5. System creates 6/7 pattern
6. Approve requests (updates schedule)
7. Publish on 25th
```

### **For Koordinator**

#### 1. Monitor Team

- View team attendance today
- Check team work reports
- Review team performance

#### 2. Approve Inventory (First Level)

```
1. Permintaan menu
2. Review CS request
3. Add notes/comments
4. Approve (forwards to Admin) or Reject
```

#### 3. HRIS - Review Leave

```
1. HRIS → Leave Management
2. Review team leave requests
3. Check legitimacy and dates
4. Approve (forwards to Admin) or Reject
```

#### 4. HRIS - Conduct Performance Review

```
1. HRIS → Performance Review
2. Select team member
3. Score each KPI (1-5)
4. Add detailed notes
5. Submit for Admin review
```

### **For CS (Cleaning Service)**

#### 1. Clock In

```
1. Open app on phone
2. Click "Absen Masuk"
3. Allow camera access
4. Take selfie photo
5. Add notes if Izin/Sakit
6. Submit
```

#### 2. Submit Work Report

```
1. After cleaning ATM
2. Click "Buat Laporan"
3. Select ATM location
4. Take 3 photos:
   - Before cleaning
   - After cleaning
   - ATM location
5. Add notes (issues/obstacles)
6. Submit
```

#### 3. Request Inventory

```
1. Go to Inventory menu
2. Click "Ajukan Permintaan"
3. Select item
4. Enter quantity needed
5. Add reason/notes
6. Submit for approval
```

#### 4. HRIS - Request Leave

```
1. HRIS → Cuti menu
2. Click "Ajukan Cuti"
3. Select leave type
4. Choose dates
5. Enter reason
6. Attach document (for sick leave)
7. Submit
8. Track approval status
```

#### 5. HRIS - View Performance

```
1. HRIS → Performance menu
2. View monthly scores
3. Read Koordinator/Admin notes
4. See improvement suggestions
5. Track progress over time
```

#### 6. HRIS - Manage Profile

```
1. Profile → Edit Profile
2. Update personal info:
   - Address
   - Phone number
   - Emergency contact
3. Upload documents:
   - KTP, KK, Ijazah, Rekening
4. Save changes
5. Wait for Admin verification
```

#### 7. HRIS - Request Day Off

```
1. HRIS → Jadwal Kerja
2. View next month schedule
3. During 23-24: Click "Request Libur"
4. Select preferred date
5. Add reason
6. Submit
7. Wait for Admin approval (before 25th)
8. View published schedule on 25th
```

---

## 🎨 Screenshots

### Admin Dashboard

![Admin Dashboard](/docs/screenshots/admin-dashboard.png)

### CS Mobile View - Attendance

![CS Attendance](/docs/screenshots/cs-attendance-mobile.png)

### Work Report with Photos

![Work Report](/docs/screenshots/work-report.png)

### Inventory Management

![Inventory](/docs/screenshots/inventory-management.png)

### HRIS - Leave Management

![Leave Management](/docs/screenshots/leave-management.png)

### HRIS - Performance Review

![Performance Review](/docs/screenshots/performance-review.png)

### HRIS - Shift Schedule

![Shift Schedule](/docs/screenshots/shift-schedule.png)

[More screenshots in /docs/screenshots/]

---

## 🧪 Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=LeaveManagementTest

# Run with coverage
php artisan test --coverage
```

### Test Coverage

- Unit Tests: Models, Services
- Feature Tests: Controllers, Routes
- Browser Tests: User flows (Dusk)

---

## 🔒 Security

- ✅ CSRF Protection (Laravel default)
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ XSS Protection (Blade escaping)
- ✅ Password Hashing (bcrypt)
- ✅ Role-based Access Control
- ✅ File Upload Validation
- ✅ Rate Limiting (API)
- ✅ Secure Session Management

---

## 🚀 Deployment

### Production Checklist

```bash
# 1. Environment
□ Set APP_ENV=production
□ Set APP_DEBUG=false
□ Generate new APP_KEY
□ Configure database credentials
□ Set up email (SMTP/Mailgun)

# 2. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev

# 3. Assets
npm run build

# 4. Security
□ Set file permissions (755 directories, 644 files)
□ Enable SSL/HTTPS
□ Configure firewall
□ Set up backups

# 5. Monitoring
□ Error logging
□ Performance monitoring
□ Uptime monitoring
```

---

## 📈 Roadmap

### Version 2.0 (Planned)

- [ ] Mobile App (React Native/Flutter)
- [ ] Push Notifications
- [ ] GPS Route Optimization
- [ ] QR Code Check-in
- [ ] Payroll Integration
- [ ] Advanced Analytics Dashboard
- [ ] Multi-language Support
- [ ] API for Third-party Integration

### Version 2.1 (Future)

- [ ] AI-powered Schedule Optimization
- [ ] Facial Recognition for Attendance
- [ ] Predictive Inventory Management
- [ ] Customer Feedback Module
- [ ] IoT Integration (Smart Sensors)

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### Coding Standards

- Follow PSR-12 coding standard
- Write meaningful commit messages
- Add tests for new features
- Update documentation

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Authors

**Your Name**

- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

---

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- All open-source contributors
- Icons by Heroicons

---

## 📞 Support

Need help? Have questions?

- 📧 Email: support@example.com
- 💬 Discord: [Join our server](https://discord.gg/example)
- 📖 Documentation: [Full docs](https://docs.example.com)
- 🐛 Bug Reports: [GitHub Issues](https://github.com/your-username/cleaning-service-atm/issues)

---

<div align="center">

**Made with ❤️ for better ATM cleaning management**

[⬆ Back to Top](#-atm-cleaning-service-management-system)

</div>
