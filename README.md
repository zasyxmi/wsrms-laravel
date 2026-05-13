# WSRMS - Workshop Repair Service Management System

WSRMS is a Laravel-based web system developed for managing workshop repair services, especially for PC, laptop, and handphone repair workflows. The system is designed to support customers, administrators, and technicians through a structured repair management process.

> **Project Status:** In Progress  
> This system is still under development. Core modules are working, but UI polishing, testing, and future enhancements are still ongoing.

---

## Project Overview

Workshop Repair Service Management System helps a repair workshop manage customer repair requests from submission until pickup. Customers can submit repair requests, track repair progress, view invoices, make payment simulation, and download receipts. Admin users can manage repair requests, customers, technicians, spare parts, invoices, payments, reports, and notifications. Technicians can view assigned tasks, update diagnosis, record spare parts used, and mark repairs as completed.

The system is developed using Laravel 11 and follows a role-based access structure.

---

## Main User Roles

### 1. Admin

The admin manages the overall repair workflow and system records.

Main functions:

- Manage repair requests
- Approve or reject repair requests
- Assign technicians
- Manage customers
- Manage technicians
- Manage devices
- Manage spare parts
- Generate invoices
- View payments
- View reports
- Receive system notifications

### 2. Customer

The customer uses the system to request and track repair services.

Main functions:

- Register and login
- Submit repair requests
- Track repair status
- View assigned technician
- View diagnosis and repair notes
- View invoice
- Make payment simulation
- View and download receipt PDF
- Receive pickup notification by system notification and email

### 3. Technician

The technician handles assigned repair tasks.

Main functions:

- View assigned repair tasks
- Update diagnosis result
- Add repair notes
- Record spare parts used
- Mark repair as completed
- Receive task assignment notifications

---

## Completed Features

- User authentication
- Role-based access control
- Admin dashboard
- Customer dashboard
- Technician dashboard
- Customer repair request module
- Admin repair request approval and assignment
- Technician repair task workflow
- Spare part management
- Invoice management
- Payment simulation
- Receipt page
- Receipt PDF download
- System notification module
- Gmail email notification for pickup message
- Admin customer management
- Admin technician management
- Admin device management
- Admin payment management
- Admin report module
- Light professional UI theme
- Redesigned login page
- Redesigned register page
- Vertical sidebar navigation
- Redesigned admin dashboard
- Redesigned customer dashboard
- Public homepage

---

## Current Development Progress

The core system flow is already working:

```text
Customer submits repair request
↓
Admin approves request
↓
Admin assigns technician
↓
Technician updates diagnosis
↓
Technician records spare parts
↓
Technician marks repair as completed
↓
Admin generates invoice
↓
Customer makes payment simulation
↓
System generates receipt
↓
Customer downloads receipt PDF
↓
Customer receives pickup notification
