# BodaBoda Digital

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue" alt="PHP Version">
  <img src="https://img.shields.io/badge/MySQL-8.0+-orange" alt="Database">
  <img src="https://img.shields.io/badge/License-MIT-green" alt="License">
</p>

<p align="center">
  <strong>Dodoma's #1 Motorcycle Ride-Hailing Platform</strong><br>
  Fast, safe, and transparent transportation solution for Dodoma city
</p>

## Table of Contents

- [About](#about)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [User Roles](#user-roles)
- [API Documentation](#api-documentation)
- [Testing](#testing)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

## About

BodaBoda Digital is a comprehensive motorcycle ride-hailing platform specifically designed for Dodoma, Tanzania. The platform connects passengers with verified motorcycle riders, providing safe, affordable, and reliable transportation services across the city.

### Key Objectives

- **Safety First**: All riders are vetted, trained, and equipped with safety gear
- **Transparent Pricing**: No surge pricing, no hidden fees - flat rates always
- **Quick Response**: Average pickup time under 3 minutes anywhere in Dodoma
- **24/7 Support**: Round-the-clock customer service for riders and passengers

## Features

### Core Features
- **Real-time GPS Tracking**: Live location tracking of rides
- **Secure Payment System**: Multiple payment options with encryption
- **Rider Verification**: Background-checked and trained riders
- **Emergency SOS**: In-app emergency button for passenger safety
- **Rating System**: Two-way rating for quality assurance
- **Multi-language Support**: Swahili and English interface

### User Features
- **Passenger App**: Book rides, track drivers, make payments
- **Rider App**: Accept rides, manage earnings, view statistics
- **Admin Dashboard**: Comprehensive management panel
- **Driver Registration**: Easy onboarding process for new riders
- **Trip History**: Complete ride history and receipts

### Admin Features
- **Dashboard Analytics**: Real-time statistics and charts
- **Rider Management**: Approve/reject rider applications
- **Trip Monitoring**: Live trip tracking and management
- **Revenue Reports**: Financial analytics and reporting
- **User Management**: Manage passengers and riders
- **Settings Panel**: Configure platform settings

## Technology Stack

### Backend
- **Framework**: Laravel 11.x
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum
- **Queue System**: Redis + Laravel Queues
- **File Storage**: Local/Cloud storage

### Frontend
- **CSS Framework**: Custom CSS (no Tailwind CDN)
- **JavaScript**: Vanilla JS + Chart.js
- **Icons**: Font Awesome 6
- **Maps**: OpenStreetMap/Leaflet
- **Responsive**: Mobile-first design

### Development Tools
- **Version Control**: Git
- **Package Manager**: Composer
- **Environment**: Docker support available
- **Testing**: PHPUnit
- **Code Quality**: PHP CS Fixer

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **MySQL**: 8.0+ or MariaDB 10.3+
- **Web Server**: Apache, Nginx, or Laravel Valet
- **Node.js**: 18+ (for asset compilation if needed)
- **Git**: For version control

### Optional (Recommended)
- **Redis**: For caching and queues
- **Docker**: For containerized development
- **Laravel Valet**: For local development (macOS)

## Installation

### Quick Start (Recommended) - Fully Automated

For the easiest installation experience, use our automated installation script that handles everything from clone to live application:

```bash
# Clone the project
git clone https://github.com/your-username/bodaboda-digital.git
cd bodaboda-digital

# Run the installation script - it does EVERYTHING automatically
./install.sh

# That's it! Your application is now live at http://localhost:8000
```

**The script handles the complete process automatically:**
- ✅ Checks system requirements
- ✅ Installs all dependencies (Composer, Node.js if available)
- ✅ Sets up environment configuration
- ✅ Builds and starts Docker containers (or local setup)
- ✅ Runs database migrations and seeding
- ✅ Creates storage links and permissions
- ✅ Optimizes application caches
- ✅ Starts the development server automatically
- ✅ **Opens the application in your web browser automatically**
- ✅ Displays login credentials and access information

**What happens after you run `./install.sh`:**
1. Script checks your system and installs everything needed
2. Sets up the complete application environment
3. Starts the development server
4. **Automatically opens http://localhost:8000 in your default browser**
5. Shows you the login credentials (admin@bodaboda.co.tz / password)
6. Application is ready to use immediately

**After running `./install.sh`, the application will be live and accessible at:**
- **Main Application**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- **Default Login**: admin@bodaboda.co.tz / password

**No additional steps required - the script does everything!**

#### How the Installation Script Works

The installation script (`install.sh`) is a comprehensive setup tool that handles the entire installation process automatically. Here's what it does:

**Step 1: System Requirements Check**
- Checks for PHP 8.2+ installation
- Verifies Composer is installed
- Validates MySQL/MariaDB availability
- Tests Docker and Docker Compose (if available)
- Confirms Git is present
- Reports any missing dependencies

**Step 2: Installation Method Selection**
The script presents an interactive menu with three options:

```
BodaBoda Digital Installation Options
Choose installation method:
1) Docker Installation (Recommended)
2) Local Installation (Manual Setup)
3) Development Setup (with dev tools)
4) Exit
```

**Option 1: Docker Installation**
- Stops any existing Docker services
- Builds and starts Docker containers (app, database, nginx)
- Waits for services to be ready
- Installs Composer dependencies inside container
- Generates Laravel application key
- Runs database migrations
- Seeds database with initial data
- Creates storage links
- Optimizes application caches
- Provides access credentials

**Option 2: Local Installation**
- Creates `.env` file from `.env.example`
- Generates Laravel application key
- Installs Composer dependencies locally
- Creates storage directories with proper permissions
- Runs database migrations
- Seeds database with initial data
- Creates storage links
- Optimizes application caches

**Option 3: Development Installation**
- Installs all Composer dependencies (including dev packages)
- Installs Node.js dependencies (if available)
- Builds frontend assets
- Sets up development environment
- Runs migrations and seeding
- Creates storage links

**Step 3: Post-Installation Information**
After successful installation, the script displays:

- **Application Access URLs**
  - Web Application: http://localhost:8000
  - Admin Panel: http://localhost:8000/admin
  - Default Login: admin@bodaboda.co.tz / password

- **Database Credentials** (Docker only)
  - Host: localhost:3306
  - Database: bodaboda
  - Username: bodaboda_user
  - Password: root

- **Useful Commands** (Docker only)
  - View logs: `docker-compose logs -f`
  - Stop services: `docker-compose down`
  - Restart services: `docker-compose restart`
  - Access shell: `docker-compose exec app bash`

- **Next Steps**
  - Read the README.md for detailed documentation
  - Configure environment variables in `.env`
  - Create user accounts for testing
  - Run tests: `php artisan test`
  - Start developing your features

#### Troubleshooting the Installation Script

**Permission Denied Error**
```bash
# Make script executable
chmod +x install.sh
```

**Docker Services Failed to Start**
```bash
# Check Docker status
docker --version
docker-compose --version

# Restart Docker daemon
sudo systemctl restart docker
```

**Database Connection Issues**
```bash
# Check database service (Docker)
docker-compose restart db

# Check database service (Local)
mysql -u root -p -e "SHOW DATABASES;"
```

**Permission Issues with Storage**
```bash
# Fix storage permissions (Docker)
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache

# Fix storage permissions (Local)
chmod -R 775 storage bootstrap/cache
```

#### Manual Script Usage

If you prefer to run specific steps manually:

```bash
# Check system requirements only
./install.sh --check-requirements

# Docker installation only
./install.sh --docker

# Local installation only
./install.sh --local

# Development setup only
./install.sh --dev
```

**Note**: The installation script is designed to be idempotent - you can run it multiple times safely. It will detect existing installations and only perform necessary steps.

### Manual Installation

If you prefer manual setup, follow these steps:

#### 1. Clone the Repository

```bash
git clone https://github.com/your-username/bodaboda-digital.git
cd bodaboda-digital
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# If you encounter issues, try:
composer install --no-dev --optimize-autoloader
```

#### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Configure Environment Variables

Edit your `.env` file and configure the following:

```env
# App Configuration
APP_NAME="BodaBoda Digital"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bodaboda_digital
DB_USERNAME=root
DB_PASSWORD=your-database-password

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@bodaboda.co.tz"
MAIL_FROM_NAME="${APP_NAME}"

# Redis Configuration (optional)
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# File Storage
FILESYSTEM_DISK=local

# Session Configuration
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

## Database Setup

### 1. Create Database

```sql
CREATE DATABASE bodaboda_digital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Run Migrations

```bash
# Run database migrations
php artisan migrate

# Seed the database with initial data
php artisan db:seed
```

### 3. Create Admin User

```bash
# Create admin user (if not created by seeder)
php artisan tinker

# In tinker, run:
User::create([
    'name' => 'Admin User',
    'email' => 'admin@bodaboda.co.tz',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

## 🏃‍♂️ Running the Application

### Development Server

```bash
# Start the development server
php artisan serve

# The application will be available at:
# http://localhost:8000
```

### Alternative Methods

```bash
# Using Laravel Valet (macOS)
valet link
valet secure

# Using Docker (Recommended)
docker-compose up -d

# Using Apache/Nginx
# Point your web server document root to the /public directory
```

## Docker Setup (Recommended)

Docker is the recommended way to run BodaBoda Digital in development and production. The project comes with pre-configured Docker files for easy setup.

### Prerequisites

- **Docker**: 20.10+ and Docker Compose 2.0+
- **Docker Desktop**: For Windows/macOS users
- **Memory**: Minimum 4GB RAM allocated to Docker

### Quick Start

```bash
# Clone and navigate to project
git clone https://github.com/your-username/bodaboda-digital.git
cd bodaboda-digital

# Start all services
docker-compose up -d

# Install Composer dependencies
docker-compose exec app composer install

# Generate application key
docker-compose exec app php artisan key:generate

# Run database migrations
docker-compose exec app php artisan migrate

# Seed the database
docker-compose exec app php artisan db:seed

# Access the application
# Open http://localhost:8000 in your browser
```

### Docker Services

The `docker-compose.yml` file includes three main services:

#### App Service (PHP-FPM)
- **Image**: Custom PHP 8.3 with required extensions
- **Purpose**: Laravel application server
- **Port**: 9000 (internal)
- **Volume**: Project directory mounted at `/var/www`

#### Database Service (MySQL 8.0)
- **Image**: `mysql:8.0`
- **Purpose**: Application database
- **Port**: `3306:3306` (host:container)
- **Database**: `bodaboda`
- **Credentials**: 
  - Username: `bodaboda_user`
  - Password: `root`
  - Root Password: `root`

#### Web Server (Nginx)
- **Image**: `nginx:alpine`
- **Purpose**: Reverse proxy for PHP-FPM
- **Port**: `8000:80` (host:container)
- **Configuration**: `nginx/conf.d/app.conf`

### Docker Configuration Files

#### Dockerfile
```dockerfile
FROM php:8.3-fpm-bookworm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory and permissions
WORKDIR /var/www
COPY --chown=www-data:www-data . /var/www

# Create storage directories
RUN mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

USER www-data
EXPOSE 9000
CMD ["php-fpm"]
```

#### docker-compose.yml
```yaml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    image: bodaboda-app
    container_name: bodaboda-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./.env.docker:/var/www/.env

  db:
    image: mysql:8.0
    container_name: bodaboda-db
    restart: unless-stopped
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: bodaboda
      MYSQL_ROOT_PASSWORD: root
      MYSQL_PASSWORD: root
      MYSQL_USER: bodaboda_user
    volumes:
      - bodaboda-dbdata:/var/lib/mysql/

  nginx:
    image: nginx:alpine
    container_name: bodaboda-nginx
    restart: unless-stopped
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www
      - ./nginx/conf.d/:/etc/nginx/conf.d/

volumes:
  bodaboda-dbdata:
    driver: local
```

#### Nginx Configuration
```nginx
server {
    listen 80;
    index index.php index.html;
    root /var/www/public;
    
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

### Docker Environment Variables

The `.env.docker` file is pre-configured for Docker:

```env
APP_NAME=BodaBoda Digital
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=bodaboda
DB_USERNAME=bodaboda_user
DB_PASSWORD=root

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
```

### Docker Commands

#### Development Commands
```bash
# Start all services
docker-compose up -d

# View logs
docker-compose logs -f app
docker-compose logs -f db
docker-compose logs -f nginx

# Stop all services
docker-compose down

# Rebuild and start
docker-compose build --no-cache
docker-compose up -d

# Access application shell
docker-compose exec app bash

# Access database
docker-compose exec db mysql -u bodaboda_user -p bodaboda
```

#### Maintenance Commands
```bash
# Clear caches
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Create storage link
docker-compose exec app php artisan storage:link
```

#### Production Commands
```bash
# Optimize for production
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app php artisan optimize

# Run production migrations
docker-compose exec app php artisan migrate --force

# Install production dependencies
docker-compose exec app composer install --no-dev --optimize-autoloader
```

### Docker Troubleshooting

#### Common Issues

1. **Permission Denied Errors**
   ```bash
   # Fix storage permissions
   docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
   docker-compose exec app chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Errors**
   ```bash
   # Restart database service
   docker-compose restart db
   
   # Check database status
   docker-compose exec db mysql -u bodaboda_user -p -e "SHOW DATABASES;"
   ```

3. **Port Conflicts**
   ```bash
   # Check what's using port 8000
   lsof -i :8000
   
   # Change port in docker-compose.yml
   ports:
     - "8080:80"  # Use port 8080 instead
   ```

4. **Memory Issues**
   ```bash
   # Increase Docker memory allocation in Docker Desktop
   # Recommended: 4GB+ RAM
   ```

#### Performance Optimization

```bash
# Use Docker volumes for better performance
# Already configured in docker-compose.yml

# Enable OPcache for PHP
# Add to Dockerfile:
RUN docker-php-ext-install opcache

# Use Redis for caching
# Add to docker-compose.yml:
  redis:
    image: redis:alpine
    container_name: bodaboda-redis
    ports:
      - "6379:6379"
```

### Docker Production Setup

For production deployment with Docker:

1. **Update environment variables**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Use production images**
   ```bash
   docker-compose -f docker-compose.prod.yml up -d
   ```

3. **Set up SSL**
   ```nginx
   server {
       listen 443 ssl;
       ssl_certificate /etc/ssl/certs/app.crt;
       ssl_certificate_key /etc/ssl/private/app.key;
       # ... other SSL config
   }
   ```

4. **Monitor containers**
   ```bash
   docker-compose ps
   docker stats
   ```

## Project Structure

```
bodaboda-digital/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Application controllers
│   │   ├── Middleware/      # Custom middleware
│   │   └── Requests/        # Form requests
│   ├── Models/              # Eloquent models
│   ├── Policies/            # Authorization policies
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories
├── resources/
│   ├── views/               # Blade templates
│   │   ├── auth/           # Authentication views
│   │   ├── admin/          # Admin panel views
│   │   └── layouts/        # Layout templates
│   ├── css/                # Custom CSS files
│   └── js/                 # JavaScript files
├── routes/
│   ├── web.php             # Web routes
│   └── api.php             # API routes
├── storage/                # File storage
├── tests/                  # Test files
└── public/                 # Public assets
```

## User Roles

The application supports three main user roles:

### Admin
- **Access**: Full admin panel access
- **Permissions**: Manage users, rides, settings, reports
- **Login**: `/admin/login` or use main login with admin credentials
- **Default**: `admin@bodaboda.co.tz` / `password`

### Rider
- **Access**: Rider dashboard and mobile app
- **Permissions**: Accept rides, manage profile, view earnings
- **Registration**: Through rider registration process
- **Verification**: Background check and training required

### Passenger
- **Access**: Passenger booking interface
- **Permissions**: Book rides, track drivers, make payments
- **Registration**: Simple sign-up process
- **Features**: Ride history, payment methods, emergency contacts

## API Documentation

### Authentication Endpoints

```http
POST /api/login          # User login
POST /api/register       # User registration
POST /api/logout         # User logout
GET  /api/user           # Get current user
```

### Ride Management

```http
GET  /api/rides          # List rides
POST /api/rides          # Create ride request
GET  /api/rides/{id}     # Get ride details
PUT  /api/rides/{id}     # Update ride status
DELETE /api/rides/{id}   # Cancel ride
```

### User Management

```http
GET  /api/users          # List users
GET  /api/users/{id}     # Get user details
PUT  /api/users/{id}     # Update user
DELETE /api/users/{id}   # Delete user
```

## Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter UserTest

# Run with coverage
php artisan test --coverage
```

### Test Database

```bash
# Reset and migrate test database
php artisan migrate:fresh --seed
```

### Example Test

```php
// Example test file: tests/Feature/RideTest.php
public function test_passenger_can_book_ride()
{
    $user = User::factory()->create(['role' => 'passenger']);
    
    $response = $this->actingAs($user)->post('/api/rides', [
        'pickup_location' => 'Dodoma City Center',
        'dropoff_location' => 'University of Dodoma',
        'fare' => 5000,
    ]);

    $response->assertStatus(201);
}
```

## Deployment

### Production Setup

1. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

2. **Install Dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Database Setup**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

4. **Optimize Application**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

5. **Set Permissions**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

### Server Requirements

- **PHP**: 8.2+ with required extensions
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Database**: MySQL 8.0+ or MariaDB 10.3+
- **Memory**: Minimum 512MB RAM
- **Storage**: Minimum 1GB disk space

### Security Considerations

- Always set `APP_ENV=production` in production
- Use HTTPS with valid SSL certificate
- Configure firewall rules
- Regular security updates
- Backup database regularly
- Monitor application logs

## Monitoring with Grafana

BodaBoda Digital includes comprehensive monitoring setup with Grafana and Prometheus for real-time insights into platform performance and business metrics.

### Monitoring Stack

- **Grafana**: Visualization dashboard (Port 3001)
- **Prometheus**: Data collection and storage (Port 9090)
- **Node Exporter**: System metrics collection (Port 9100)
- **Custom Metrics**: BodaBoda-specific business metrics

### Quick Start with Monitoring

```bash
# Start all services including monitoring
docker-compose up -d

# Access monitoring interfaces
# Grafana Dashboard: http://localhost:3001
# Prometheus: http://localhost:9090
# Node Exporter: http://localhost:9100

# Default Grafana credentials
# Username: admin
# Password: admin123
```

### Available Metrics

#### Business Metrics
- **Total Rides**: Complete count of all rides
- **Active Users**: Number of registered users
- **Active Rides**: Currently ongoing rides
- **Completed Rides**: Successfully finished rides
- **Total Revenue**: Revenue in Tanzanian Shillings (TZS)
- **Average Ride Duration**: Average time per ride
- **Rider Applications**: Total rider registration requests

#### System Metrics
- **Memory Usage**: Application memory consumption
- **CPU Usage**: System processor utilization
- **Response Time**: Average API response time
- **Error Rate**: Percentage of failed requests
- **Database Connections**: Active database connections
- **Cache Hit Rate**: Cache performance metrics

#### Infrastructure Metrics
- **System Load**: Server load averages
- **Disk Usage**: Storage utilization
- **Network Traffic**: Network I/O statistics
- **Container Health**: Docker container status

### Grafana Dashboards

#### BodaBoda Platform Overview

![BodaBoda Monitoring Dashboard](assets/images/monitoring-dashboard.png)

The comprehensive dashboard includes:
- **Real-time Statistics**: Live platform metrics
- **Performance Trends**: Historical performance data
- **Business KPIs**: Key business indicators
- **System Health**: Infrastructure monitoring
- **Alert Thresholds**: Configurable alerts

### Accessing Monitoring

1. **Grafana Dashboard**
   ```
   URL: http://localhost:3001
   Username: admin
   Password: admin123
   ```

2. **Prometheus Interface**
   ```
   URL: http://localhost:9090
   Query metrics directly
   View target status
   ```

3. **Metrics Endpoint**
   ```
   URL: http://localhost:8000/metrics
   Prometheus format data
   Real-time metrics
   ```

### Custom Metrics Configuration

The MetricsController (`app/Http/Controllers/MetricsController.php`) provides:

- **Business Logic Metrics**: Rides, users, revenue
- **Performance Metrics**: Response times, error rates
- **System Metrics**: Memory, CPU, database
- **Custom KPIs**: Platform-specific indicators

### Alerting Setup

Configure alerts in Grafana for:

- **High Error Rates**: > 5% error rate
- **Slow Response Times**: > 2 second average
- **Low Active Rides**: < 1 active ride for 30 minutes
- **High Memory Usage**: > 80% memory utilization
- **Database Issues**: Connection failures

### Monitoring Best Practices

1. **Regular Review**: Check dashboards daily
2. **Alert Configuration**: Set up meaningful alerts
3. **Performance Baselines**: Establish normal ranges
4. **Historical Analysis**: Review trends weekly
5. **Capacity Planning**: Monitor growth patterns

### Troubleshooting Monitoring

**Grafana Not Accessible**
```bash
# Check Grafana container status
docker-compose ps grafana

# Restart Grafana service
docker-compose restart grafana

# Check Grafana logs
docker-compose logs grafana
```

**Prometheus Not Collecting Data**
```bash
# Check Prometheus targets
curl http://localhost:9090/api/v1/targets

# Check metrics endpoint
curl http://localhost:8000/metrics

# Restart Prometheus
docker-compose restart prometheus
```

**Missing Metrics**
```bash
# Verify metrics endpoint works
curl -s http://localhost:8000/metrics | head -20

# Check Laravel logs
docker-compose logs app | grep metrics
```

### Monitoring Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   BodaBoda App  │───▶│   Prometheus    │───▶│     Grafana     │
│   (Metrics)     │    │   (Collection)  │    │  (Visualization)│
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│  Node Exporter  │    │   MySQL Exporter│    │   Nginx Exporter│
│  (System)        │    │   (Database)    │    │   (Web Server)  │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

### Production Monitoring

For production deployment:

1. **Persistent Storage**: Configure data retention
2. **Security**: Secure Grafana access
3. **Backup**: Regular dashboard backups
4. **Scaling**: Multiple monitoring instances
5. **Integration**: External alerting systems

## Contributing

We welcome contributions! Please follow these steps:

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/amazing-feature
   ```
3. **Commit your changes**
   ```bash
   git commit -m 'Add amazing feature'
   ```
4. **Push to the branch**
   ```bash
   git push origin feature/amazing-feature
   ```
5. **Open a Pull Request**

### Code Standards

- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages
- Keep code clean and readable

## Bug Reports

If you find a bug, please:

1. Check existing issues
2. Create a new issue with:
   - Clear description
   - Steps to reproduce
   - Expected vs actual behavior
   - Environment details
   - Screenshots if applicable

## Support

For support and questions:

- **Email**: support@bodaboda.co.tz
- **Phone**: +255 700 000 000
- **Documentation**: [Project Wiki](https://github.com/your-username/bodaboda-digital/wiki)
- **Issues**: [GitHub Issues](https://github.com/your-username/bodaboda-digital/issues)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Laravel team for the amazing framework
- Dodoma city authorities for support
- All riders and passengers using the platform
- Open source community contributors

---

<p align="center">
  <strong>Made with love for Dodoma City</strong><br>
  <em>Fast. Safe. Reliable.</em>
</p>
