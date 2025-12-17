# Deployment Guide: Hostinger Hosting

## Project Overview
- **Project Size**: 122.16 MB (dengan node_modules)
- **Production Size**: ~71.66 MB (tanpa node_modules)
- **PHP Version**: 8.2+
- **Laravel Version**: 12.0
- **Database**: PostgreSQL/MySQL

## Hosting Options di Hostinger

### 1. Shared Hosting (Recommended untuk budget)
**Business Web Hosting - $3.99/bulan**
- **Storage**: 100 GB SSD
- **PHP**: 8.2+ tersedia
- **Database**: MySQL 5.7+
- **Fitur**: cPanel, SSL Gratis

### 2. Cloud Hosting (Recommended untuk performance)
**Cloud Startup - $9.99/bulan**
- **Storage**: 50 GB NVMe
- **RAM**: 2 GB
- **PHP**: 8.2+ tersedia
- **Database**: PostgreSQL/MySQL
- **Fitur**: Full control, SSH access

## Preparation Checklist

### 1. Project Optimization
```bash
# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets
npm install
npm run build
```

### 2. Environment Setup
```env
# Production Environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# File Storage
FILESYSTEM_DISK=public

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
```

### 3. File Upload Preparation
**Exclude dari upload:**
- `node_modules/`
- `.git/`
- `storage/logs/`
- `storage/framework/cache/`
- `.env`
- `phpunit.xml`
- `README.md`

**Include dalam upload:**
- Semua file project
- `vendor/` (jika tidak bisa install di server)
- `public/storage/` (symlink)

## Deployment Methods

### Method 1: Shared Hosting (cPanel)

1. **Upload Files**
   - Zip project folder
   - Upload via cPanel File Manager
   - Extract di `public_html/`

2. **Database Setup**
   - Create database di cPanel
   - Import SQL file jika ada

3. **Environment Setup**
   - Create `.env` file
   - Set permissions:
     ```bash
     chmod 755 storage/
     chmod 755 bootstrap/cache/
     chmod 644 .env
     ```

4. **Composer Install**
   - Via cPanel Terminal:
     ```bash
     composer install --no-dev
     ```

5. **Final Setup**
   ```bash
   php artisan key:generate
   php artisan storage:link
   php artisan migrate --force
   ```

### Method 2: Cloud Hosting (SSH)

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/project.git
   cd project
   ```

2. **Install Dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install
   npm run build
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate --force
   ```

5. **Optimize**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Post-Deployment Configuration

### 1. Web Server Configuration
**Apache (.htaccess)**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

**Nginx**
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 2. Cron Job Setup
**Shared Hosting (cPanel)**
```bash
* * * * * /usr/bin/php /home/username/project/artisan schedule:run >> /dev/null 2>&1
```

**Cloud Hosting (Crontab)**
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Queue Worker (jika menggunakan)
```bash
* * * * * cd /path/to/project && php artisan queue:work --sleep=3 --tries=3 --max-time=60
```

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check `.env` file permissions
   - Verify database connection
   - Check PHP version compatibility

2. **File Upload Issues**
   - Set correct permissions:
     ```bash
     chmod -R 755 storage/
     chmod -R 755 bootstrap/cache/
     ```

3. **Database Connection**
   - Verify database credentials
   - Check database server status
   - Ensure database exists

4. **Asset Loading Issues**
   - Run `php artisan storage:link`
   - Check asset permissions
   - Clear config cache

## Security Recommendations

1. **Environment File**
   - Keep `.env` file secure
   - Set proper permissions (644)

2. **File Permissions**
   ```bash
   chmod 755 storage/
   chmod 755 bootstrap/cache/
   chmod 644 .env
   ```

3. **Database Security**
   - Use strong passwords
   - Limit database user permissions
   - Enable SSL if available

## Performance Optimization

1. **Enable OPcache**
2. **Use Redis untuk cache** (jika available)
3. **Enable Gzip compression**
4. **Use CDN untuk assets**
5. **Optimize images**

## Monitoring & Maintenance

1. **Regular Backups**
2. **Monitor disk space**
3. **Update dependencies**
4. **Check logs regularly**
5. **Monitor performance**

## Support Resources

- **Hostinger Documentation**: https://www.hostinger.com/tutorials
- **Laravel Documentation**: https://laravel.com/docs
- **cPanel Guide**: https://docs.cpanel.net/

## Quick Deployment Commands

```bash
# Final production setup
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
php artisan migrate --force
php artisan optimize:clear
```
