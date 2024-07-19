# Point of Sale (POS) Web Application

## Overview

This is a comprehensive Point of Sale (POS) web application designed to streamline sales processes for retail businesses. It features an admin side for managing products, customers, and transactions, as well as a real-time dashboard for monitoring sales.

## Features

### Admin Side

- **Product Management**: Add, edit, and delete products. Manage product inventory and pricing.
- **Customer Management**: Add and manage customer details.
- **Transaction Management**: View transaction history and details.
- **User Management**: Manage admin and cashier users with role-based access control.

### Sales Dashboard

- **Real-time Sales Chart**: Monitor sales in real-time with dynamic charts.
- **Daily, Weekly, and Monthly Reports**: Generate and view sales reports for different periods.
- **Transaction Details**: View detailed information about each transaction.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript (jQuery)
- **Backend**: PHP, MySQL
- **Charting**: Chart.js for real-time sales charts
- **Libraries**: DataTables for transaction and product listings

## Installation

1. **Clone the repository:**

   ```sh
   git clone https://github.com/yourusername/pos-webapp.git
   cd pos-webapp
2. **Set up the database:**
- Create a new MySQL database.
- Import the database.sql file located in the sql folder into your MySQL database.
- Update the database configuration in config.php with your database details.

  ```php
  // config.php
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'your_db_username');
  define('DB_PASSWORD', 'your_db_password');
  define('DB_NAME', 'your_db_name');

3. **Configure the web server::**
- Ensure your web server (e.g., Apache, Nginx) is configured to serve the application.
- Place the application files in the web server's root directory or a subdirectory.
- Update the base URL in config.php if necessary.

4. **Install dependencies:**
- Ensure you have PHP and MySQL installed on your server.
- Install any required PHP extensions (e.g., PDO for database access).

## Contact

For questions or support, please contact [developer](mailto:app@metipix.co.zw).
