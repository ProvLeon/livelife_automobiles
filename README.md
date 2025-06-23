# LiveLife Automobiles - Car Rental Management System

A comprehensive web-based car rental management system built with PHP and MySQL, featuring automated email notifications and user-friendly booking management.

## Features

### Core Functionality
- **Customer Registration & Login** - Secure user authentication system
- **Admin Panel** - Complete administrative control over cars, drivers, and bookings
- **Car Management** - Add, update, and remove vehicles from the fleet
- **Driver Management** - Manage driver profiles and assignments
- **Booking System** - Real-time car availability and reservation system
- **Payment Processing** - Integrated payment handling with confirmation
- **Booking Management** - View, track, and manage all reservations

### New Email Features ✨
- **Welcome Emails** - Automated welcome messages for new customer and admin registrations
- **Booking Confirmation Emails** - Detailed booking confirmation with all rental details
- **Professional Email Templates** - Mobile-responsive HTML email templates
- **Email Configuration** - Easy SMTP setup with Gmail and other providers

## Setup Instructions

### 1. Database Setup
Database files are located in the "Database" folder. Import to your localhost (phpMyAdmin) or server.

### 2. Database Connection
Configure the `config.php` file to set up database connections and email settings:

```php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'carrental');

// Email configuration
define('EMAIL_ACC', 'your-email@gmail.com');
define('EMAIL_PASSWORD', 'your-app-password');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_SECURE', 'ssl');
define('SMTP_PORT', 465);
```

### 3. Email Setup
For detailed email configuration instructions, see [EMAIL_SETUP.md](EMAIL_SETUP.md).

**Quick Setup:**
1. Enable 2-Factor Authentication on your Gmail account
2. Generate an App Password for the application
3. Update the email settings in `config.php`
4. Test the configuration using `test_email.php`

## File Structure

### Core Files
- `config.php` - Main configuration file
- `connection.php` - Database connection handler
- `email_service.php` - Email functionality service
- `index.php` - Landing page

### User Management
- `customersignup.php` / `customer_registered_success.php` - Customer registration
- `adminsignup.php` / `admin_registered_success.php` - Admin registration
- `customerlogin.php` / `adminlogin.php` - User authentication

### Booking System
- `booking.php` - Car booking interface
- `process_payment.php` - Payment processing and email sending
- `booking_confirmation.php` - Booking confirmation with email status

### Testing & Documentation
- `test_email.php` - Email configuration testing tool
- `EMAIL_SETUP.md` - Comprehensive email setup guide

## Technologies Used
- **Backend:** PHP 7.4+
- **Database:** MySQL
- **Email:** PHPMailer with SMTP
- **Frontend:** HTML5, CSS3, Bootstrap 4, JavaScript
- **Icons:** Font Awesome

### Screenshots:
> - Landing Page
<img src="/Screenshots/index.jpg" width="800" height="450" alt="landing_page"/>

> - Available Cars
<img src="/Screenshots/available_cars.png" width="800" height="450" alt="available_cars"/>

> - Add Cars
<img src="/Screenshots/add_car.png" width="800" height="700" alt="add_car"/>

> - Booking Confirmation
<img src="/Screenshots/booking_confirmation.png" width="800" height="800" alt="booking_confirm"/>

> - Return Car
<img src="/Screenshots/return_car.png" width="800" height="450" alt="return_car"/>

> - Booking Summary
<img src="/Screenshots/bookings.png" width="800" height="450" alt="booking_summary"/>
