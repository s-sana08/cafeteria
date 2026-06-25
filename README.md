# 🍽️ Cafeteria Management System

A full-featured **Cafeteria Management System** built using **PHP, MySQL, AJAX, jQuery, and Bootstrap**.  
This system is designed for companies to manage employees, vendors, food services, departments, and cafeteria operations efficiently.

---

## 🚀 Project Overview

This system automates cafeteria operations inside a company environment where:

- Admin manages employees, vendors, companies, departments
- Vendors provide food services (Pizza, Meals, Snacks, etc.)
- Employees are assigned food plans
- Requests and approvals are tracked
- Activity logs are maintained for transparency

---

## ✨ Features

### 👨‍💼 Admin Panel
- Add / Edit / Delete Admin users
- Role-based access control
- Activity logs tracking all actions

### 👥 Employee Management
- Add employees with company & department mapping
- Employee ID validation (duplicate check)
- Food allocation system (1 time / 2 times)
- Status toggle system (Active/Inactive)
- AJAX-based dynamic operations

### 🏢 Company Management
- Add multiple companies
- Assign employees to companies
- Duplicate validation for company names

### 🏬 Department Management
- Add and manage departments
- Assign employees to departments
- Duplicate validation

### 🍱 Vendor Management
- Add vendors for cafeteria services
- Vendor login system
- OTP verification system (optional)
- Food type assignment

### 🍕 Food Management
- Manage food types (Pizza, Meals, Snacks, etc.)
- Vendor food mapping system
- Easy menu control

### 📩 OTP System
- Email OTP verification for vendors
- Session-based OTP storage
- Secure verification process

### 📊 Activity Logs
- Tracks all admin actions
- Logs INSERT, UPDATE, STATUS changes
- Helps maintain audit history

---

## 🛠️ Tech Stack

- Backend: PHP (Core PHP OOP)
- Frontend: HTML, CSS, Bootstrap 5
- Client-side: JavaScript, jQuery, AJAX
- Database: MySQL
- UI Alerts: SweetAlert2

---

## 📂 Project Structure

cafeteria/
│
├── api/
│   ├── add_emp_operations.php
│   ├── add_vendor_operations_otp.php
│   ├── admin_master_operations.php
│   ├── approved_request.php
│   ├── check_duplicate_email.php
│   ├── check_duplicate_empid.php
│
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│       ├── ss_logo.png
│       ├── logo.png
│
├── config.php
├── index.php
├── dashboard.php
├── login.php

---

## ⚙️ Installation Guide

### 1️⃣ Clone Project
```bash
git clone https://your-repository-link.git


### 2️⃣ Move to XAMPP Folder

Place project inside:
htdocs/cafeteria/

### 3️⃣ Import Database

Import your SQL file into MySQL:

cafeteria_db.sql


### 4️⃣ Configure Database

Edit config.php:
$conn = new mysqli("localhost", "root", "", "cafeteria_db");

### 5️⃣ Run Project

Open browser:
http://localhost/cafeteria/


##🔐 Security Features
Session-based authentication
Role-based access control
Prepared statements (SQL Injection protection)
Duplicate validation APIs
OTP verification system

##📡 API Features

All system operations are handled via AJAX APIs:

Employee CRUD operations
Vendor management
Admin management
Dropdown fetching
Status toggle system
OTP send & verify

##📊 Key Modules
Module	Description
Admin	System control & management
Employee	Employee lifecycle management
Vendor	Food service providers
Company	Organization structure
Department	Department mapping
Food System	Food types & allocation
OTP System	Secure verification

##🎯 System Workflow
Admin logs in
Creates companies & departments
Adds employees
Assigns food preferences
Vendors provide food services
Requests are tracked
Activity logs stored automatically

##📷 UI Features
Dark / Light theme support
Responsive Bootstrap design
SweetAlert notifications
AJAX-powered smooth UI
Dynamic table updates
🏁 Conclusion

The Cafeteria Management System successfully automates cafeteria operations within an organization. It simplifies employee food management, vendor coordination, and administrative control using a secure and scalable PHP-MySQL architecture.

This system improves efficiency, reduces manual work, and provides a centralized platform for cafeteria management.

---

## 👨‍💻 Developer

Project Name: Cafeteria Management System  
Developer: SS Dev Team  
Type: Internal Enterprise Project  

---