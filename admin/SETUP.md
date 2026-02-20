# Setup Instructions - Dakic CMS Admin Panel

## Quick Start Guide

### Step 1: Database Setup

You have three options to set up the database:

#### Option A: Web-based Installer (Easiest)
1. Open your browser and go to:
   ```
   http://localhost/dakic_cms/admin/database/install_web.php
   ```
2. Click "Start Installation"
3. Wait for the success message
4. Note the default admin credentials

#### Option B: phpMyAdmin
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click "New" to create a database
3. Name it: `dakic_cms`
4. Select the database
5. Go to "Import" tab
6. Choose file: `admin/database/setup.sql`
7. Click "Go"

#### Option C: Command Line
1. Open command prompt
2. Navigate to: `c:\wamp64\www\dakic_cms\admin\database`
3. Run: `php install.php` (if PHP is in your PATH)

### Step 2: Verify Configuration

Check `admin/config/config.php` and ensure database settings are correct:
- Host: `localhost`
- Database: `dakic_cms`
- User: `root`
- Password: `` (empty)

### Step 3: Access Admin Panel

1. Open your browser
2. Navigate to: `http://localhost/dakic_cms/admin`
3. You should be redirected to the login page

### Step 4: Login

Use the default credentials:
- **Username:** `admin`
- **Password:** `admin123`

**⚠️ IMPORTANT:** Change this password immediately after first login!

## Default Admin Account

After installation, you can login with:
- Username: `admin`
- Password: `admin123`
- Email: `admin@dakic-cms.com`
- Role: `admin`

## Troubleshooting

### Database Connection Error
- Make sure MySQL/MariaDB is running in WAMP
- Verify database credentials in `admin/config/config.php`
- Check if database `dakic_cms` exists

### Login Not Working
- Make sure the database was created successfully
- Verify the `users` table exists and has the admin user
- Check browser console for JavaScript errors
- Check PHP error logs

### Page Not Found (404)
- Make sure mod_rewrite is enabled in Apache
- Verify `.htaccess` file exists in `admin/` folder
- Check Apache configuration allows `.htaccess` overrides

## Next Steps

After successful login:
1. You'll see the Dashboard
2. The dashboard is ready for further development
3. You can now add more features and modules

## Security Recommendations

1. **Change default password** immediately
2. **Remove or secure** `admin/database/install_web.php` in production
3. **Update database credentials** in production
4. **Set proper file permissions** on sensitive files
5. **Enable HTTPS** in production
6. **Regular backups** of your database

## File Structure

```
admin/
├── config/          # Configuration files
├── controllers/     # MVC Controllers
├── models/          # Database models
├── views/           # View templates
├── database/        # Database setup files
│   ├── install_web.php  # Web installer
│   ├── install.php      # CLI installer
│   └── setup.sql        # SQL file
└── ...
```

## Support

If you encounter any issues:
1. Check the error logs in `admin/logs/`
2. Verify all files are in place
3. Check PHP and MySQL versions compatibility
4. Review the README.md files in each directory
