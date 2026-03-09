# online-art-store

Database-driven e-commerce web application built with **PHP, MySQL, HTML, CSS, and JavaScript**.

This project was developed for the **HIT326 Database-Driven Web Applications** unit at Charles Darwin University.

## Features

- Dynamic product listing from database
- Shopping cart using PHP sessions
- Order submission with customer details
- Automated order confirmation email using PHPMailer
- Admin panel for testimonial moderation and news posting
- Testimonial submission system
- Input validation and SQL injection protection

## Technologies Used

- PHP
- MySQL
- HTML / CSS
- JavaScript
- PHPMailer
- XAMPP (local server)

## Project Structure

- assets/ CSS and JavaScript files
- views/ Frontend pages
- lib/ Backend models and logic
- index.php Main application entry
- art_store_db.sql Database schema

## Running the Project Locally

1. Install **XAMPP**
2. Start **Apache** and **MySQL**
3. Copy the project folder into: xampp/htdocs/
4. Open **phpMyAdmin**
5. Create a database called: art_store_db
6. Import the file: art_store_db.sql
7. Open in browser: http://localhost/online-art-store/

## Email Configuration

This project uses **PHPMailer** to send order confirmation emails.

To enable email sending:

1. Open `lib/email_config.php`
2. Enter your SMTP email credentials.

Example configuration:
- 'smtp_host' => 'smtp.gmail.com',
- 'smtp_port' => 587,
- 'smtp_user' => 'your-email@gmail.com',
- 'smtp_pass' => 'your-app-password'

If email is not configured, the application will still run but emails will not be sent.

## Admin Login

Email: admin123@gmail.com
Password: admin123
