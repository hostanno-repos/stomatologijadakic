# Admin Panel - Custom CMS

This is the admin panel for the custom CMS.

## Directory Structure

```
admin/
├── api/              # API endpoints
├── assets/           # CSS, JS, images, uploads
├── auth/             # Authentication related files
├── classes/          # Core classes
├── config/           # Configuration files
├── controllers/      # MVC Controllers
├── database/         # Database related files
├── helpers/          # Helper functions
├── includes/         # Bootstrap and autoloader
├── logs/             # Application logs
├── models/           # MVC Models
├── temp/             # Temporary files
├── utils/            # Utility classes
└── views/            # MVC Views
    └── layouts/      # View layouts
```

## Getting Started

1. Configure database settings in `config/config.php`
2. Set up your database tables
3. Access the admin panel at `/admin`
4. Default route is Dashboard

## Security Notes

- All sensitive files are protected by `.htaccess`
- CSRF protection is built-in
- Password hashing uses bcrypt
- Session management is configured

## Development

- Controllers extend `BaseController`
- Models should be placed in `models/` directory
- Views are in `views/` directory
- Use the autoloader for class loading
