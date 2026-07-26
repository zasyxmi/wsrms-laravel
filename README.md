# Workshop Repair Service Management System (WSRMS)

A full-stack web-based Workshop Repair Service Management System developed using Laravel 11 to digitalize and streamline the entire repair service workflow. The system manages repair requests, technician assignments, spare parts inventory, invoicing, online payment, receipt generation, and customer notifications within a centralized platform.

---

## Project Overview

The Workshop Repair Service Management System (WSRMS) was developed to replace manual repair management processes commonly found in small and medium-sized repair workshops. The system provides a centralized platform for managing customer repair requests, technician assignments, repair progress, spare parts inventory, invoice generation, payment processing, and device collection.

The application follows the Laravel MVC architecture and supports three different user roles:

- Administrator
- Technician
- Customer

The complete repair workflow begins when a customer submits a repair request and ends when the repaired device is collected.

---

## System Features

### Authentication & Authorization

- User Registration
- User Login & Logout
- Forgot Password
- Password Reset
- Email Verification
- Profile Management
- Role-Based Access Control (Admin, Technician, Customer)

---

### Customer Module

- Submit Repair Request
- Register Device Information
- Track Repair Progress
- View Repair History
- View Generated Invoice
- Online Payment
- Download PDF Receipt
- Receive Email Notifications
- Receive System Notifications

---

### Administrator Module

#### Dashboard

- Workshop Summary
- Monthly Sales Analytics
- Revenue Overview
- Recent Repair Requests
- Pending Invoice Queue
- Payment Monitoring
- Low Stock Monitoring

#### Repair Management

- Review Repair Requests
- Approve or Reject Requests
- View Repair Details
- Confirm Device Pickup

#### Smart Technician Assignment

- Automatic Technician Assignment
- Manual Technician Assignment
- Assignment Based on:
  - Device Type
  - Technician Specialization
  - Availability

#### Customer Management

- View Customer Information
- View Repair History

#### Technician Management

- Create Technician Account
- Update Technician Information
- Reset Technician Password
- Delete Technician
- Manage Availability

#### Spare Parts Management

- Create
- Read
- Update
- Delete
- Inventory Monitoring
- Low Stock Detection

#### Invoice Management

- Pending Invoice Queue
- Invoice History
- Generate Invoice
- Waiting Payment Workflow

#### Payment Management

- Payment History
- Payment Details
- Payment Monitoring

#### Reporting

- Repair Reports
- Invoice Reports
- Payment Reports
- Monthly Sales Summary

---

### Technician Module

- View Assigned Repair Tasks
- Update Diagnosis
- Update Repair Notes
- Record Spare Parts Usage
- Update Repair Status
- Mark Repair as Completed

---

## Technology Stack

### Backend

- Laravel 11
- PHP 8.x
- Eloquent ORM
- MVC Architecture

### Frontend

- Blade Template Engine
- Tailwind CSS
- JavaScript
- Alpine.js
- GSAP
- Chart.js
- Vite

### Database

- MySQL

### Development Environment

- Laragon
- Composer
- Node.js
- Git
- GitHub

---

## Payment Gateway Integration

The system integrates with ToyyibPay Sandbox API to simulate online payment processing.

Implemented features include:

- Bill Creation
- Payment Simulation
- Return URL Handling
- Callback URL Verification
- Hash Verification
- Payment Status Tracking
- Automatic Payment Recording
- Invoice Status Update

---

## PDF & Email Features

### PDF Generation

- Receipt PDF
- Invoice Download

Library Used:

- barryvdh/laravel-dompdf

### Email Notifications

Laravel SMTP Mail is used for:

- Repair Approval
- Invoice Generation
- Payment Confirmation
- Ready for Pickup Notification

---

## Notification System

The system automatically generates notifications for:

- Repair Approved
- Repair Rejected
- Technician Assigned
- Diagnosis Updated
- Spare Parts Recorded
- Repair Completed
- Invoice Generated
- Payment Successful
- Ready for Pickup
- Device Collected

---

## Inventory Management

- Spare Parts CRUD
- Automatic Stock Deduction
- Low Stock Monitoring
- Prevent Deletion of Used Parts

---

## Database Tables

- users
- customers
- technicians
- devices
- repair_requests
- spare_parts
- repair_spare_parts
- invoices
- payments
- system_notifications

---

## Main Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Customer/
│   │   └── Technician/
│   ├── Middleware/
│   └── Requests/
│
├── Models/
├── Mail/
└── Notifications/

database/
├── migrations/
└── seeders/

resources/
├── views/
├── css/
└── js/

routes/
└── web.php
```

---

## Installation

Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/wsrms-laravel.git
```

Install dependencies

```bash
composer install
npm install
```

Create environment file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure database credentials in `.env`

Run database migrations

```bash
php artisan migrate --seed
```

Start development server

```bash
php artisan serve
npm run dev
```

---

## Screenshots

The following screenshots are recommended for documentation:

## System Screenshots

| Module | Preview |
|--------|---------|
| Login Page | ![Login](Screenshots/Login%20Page.png) |
| Admin Dashboard | ![Admin](Screenshots/Admin%20Dashboard.png) |
| Customer Dashboard | ![Customer](Screenshots/Customer%20Dashboard.png) |
| Technician Dashboard | ![Technician](Screenshots/Technician%20Dashboard.png) |

---

## Project Highlights

- Complete End-to-End Repair Workflow
- Smart Technician Auto Assignment
- ToyyibPay Sandbox Integration
- Invoice & Payment Management
- PDF Receipt Generation
- Email Notification System
- Inventory Management
- Dashboard Analytics
- Responsive User Interface
- Role-Based Authentication
- Laravel MVC Architecture

---

## Academic Information

**Course**

ITT626 – Back-End Technology

**Project Title**

Workshop Repair Service Management System (WSRMS)

**Institution**

Universiti Teknologi MARA (UiTM)

Faculty of Computer and Mathematical Sciences

---

## License

This project was developed for academic purposes as part of the ITT626 Back-End Technology course at Universiti Teknologi MARA (UiTM).
