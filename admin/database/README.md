# Database Setup

This directory contains database setup files for Dakic CMS.

## Installation Methods

### Method 1: Web-based Installer (Recommended)

1. Open your browser and navigate to:
   ```
   http://localhost/dakic_cms/admin/database/install_web.php
   ```

2. Click "Start Installation" and follow the prompts.

3. After installation, you'll be provided with default admin credentials.

### Method 2: Command Line

1. Open command prompt or terminal
2. Navigate to the database directory:
   ```bash
   cd c:\wamp64\www\dakic_cms\admin\database
   ```
3. Run the installer:
   ```bash
   php install.php
   ```

### Method 3: phpMyAdmin (Manual)

1. Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)
2. Import the SQL file: `setup.sql`
3. Or manually create the database and run the SQL statements from `setup.sql`

## Default Admin Credentials

After installation, you can login with:

- **Username:** `admin`
- **Password:** `admin123`
- **Email:** `admin@dakic-cms.com`

**⚠️ IMPORTANT:** Change the default password immediately after first login!

## Database Structure

The installation creates:

- **Database:** `dakic_cms`
- **Table:** `users` with the following structure:
  - `id` - Primary key
  - `username` - Unique username
  - `email` - Unique email address
  - `password` - Hashed password (bcrypt)
  - `first_name` - User's first name
  - `last_name` - User's last name
  - `role` - User role (admin, editor, author)
  - `status` - Account status (active, inactive, suspended)
  - `last_login` - Last login timestamp
  - `created_at` - Account creation timestamp
  - `updated_at` - Last update timestamp

## Security Notes

- The web installer (`install_web.php`) should be disabled or removed in production
- Always use strong passwords
- Regularly update your database credentials in `config/config.php`
