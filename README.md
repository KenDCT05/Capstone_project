# Web-Based Learning Platform with Engagement Analytics and Performance Monitoring

A web-based Learning Management System (LMS) built using Laravel 12. The system manages students, teachers, sections, subjects, and grades in a structured academic environment. It includes an interactive spreadsheet-style gradebook and role-based access control.

---

## Overview

This platform centralizes academic management.  
It allows administrators to manage users and sections, teachers to manage subjects and grades, and students to view their academic performance.

The system is designed using Laravel’s MVC architecture and a relational MySQL database.

---

## Main Features

### *Role-Based Login*
* Admin, Teacher, Student accounts  
* Laravel built-in authentication  
* First login password change required  
* Role checking using `$user->role`

### *Grade and Section System*
* Grade level and section combined in one table  
* Admin assigns students and teachers to sections  

### *Subject Management*
* Teachers create subjects with descriptions  
* Subjects linked to sections  

### *Interactive Gradebook*
* Spreadsheet-style interface using Handsontable  
* Add, rename, and delete columns  
* Real-time updates using AJAX  
* Separate views for Admin, Teacher, and Student  

---

## Tech Stack

### *Backend*
* PHP 8+  
* Laravel 12  
* MySQL  
* Eloquent ORM  
* RESTful routes  

### *Frontend*
* Blade  
* Tailwind CSS  
* JavaScript  
* Handsontable  

### *Other*
* Semaphore (SMS notification integration)
* Google SMTP (Gmail Mailer via Laravel)

---

## Installation



## Purpose

This project was developed as part of a BSIT academic requirement. It demonstrates skills in:

* Full-stack web development  
* Database design  
* Authentication and role management  
* MVC architecture  
* Interactive front-end integration  
