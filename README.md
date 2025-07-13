# Snickers Universe – Candy-Themed E-Commerce Web App

Snickers Universe is a niche e-commerce platform built for fans of Snickers candy. The application offers a secure, dynamic shopping experience where users can browse themed merchandise, manage their cart, and view past orders. It features robust inventory management and role-based access for employees to maintain product listings and customer transactions.

Developed as a final group project for the Database Systems course at Montclair State University, this full-stack web application showcases database-driven design, user role management, and real-time transaction processing.

## Features

-  **Client Functionality**:
  - Browse and search Snickers-themed products across multiple categories
  - Add items to a cart and complete a streamlined, secure checkout
  - View past purchases organized by order date and contents

- **Employee Dashboard**:
  - Role-based login for Admins and Managers
  - View, insert, delete, and update inventory data
  - Monitor all customer orders and manage product stock levels

- **Security & Design**:
  - Role authentication with session management
  - SQL injection prevention and data validation
  - All visible content stored in the MySQL database

## Tech Stack

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL, phpMyAdmin  
- **Hosting**: University CPanel Server (Linux environment)

## Data Model Highlights

- **Users Table**: Includes client info and credentials (hashed)  
- **Employees Table**: Tracks admins/managers with role-based access  
- **Products & Categories**: Products are grouped by category using foreign keys  
- **Orders & Order Items**: Supports multi-item orders and stores purchase history with timestamps  
- **Inventory Management**: Updates in real-time as orders are placed

