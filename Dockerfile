FROM php:8.3-fpm-bookworm

# Install system dependencies including nginx and supervisor
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . /var/www

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Set permissions
RUN mkdir -p storage/logs \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache \
        bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www

# Write nginx config
RUN printf 'server {\n\
    listen 80;\n\
    root /var/www/public;\n\
    index index.php index.html;\n\
\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
\n\
    location ~ \\.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
\n\
    location ~ /\\.ht {\n\
        deny all;\n\
    }\n\
}\n' > /etc/nginx/sites-available/default

# Write supervisor config
RUN printf '[supervisord]\n\
nodaemon=true\n\
user=root\n\
\n\
[program:php-fpm]\n\
command=php-fpm -F\n\
autostart=true\n\
autorestart=true\n\
stderr_logfile=/var/log/php-fpm.err.log\n\
stdout_logfile=/var/log/php-fpm.out.log\n\
\n\
[program:nginx]\n\
command=nginx -g "daemon off;"\n\
autostart=true\n\
autorestart=true\n\
stderr_logfile=/var/log/nginx.err.log\n\
stdout_logfile=/var/log/nginx.out.log\n' > /etc/supervisor/conf.d/app.conf

# Write startup script
RUN printf '#!/bin/bash\n\
set -e\n\
cd /var/www\n\
php artisan key:generate --force\n\
php artisan config:clear\n\
php artisan config:cache\n\
php artisan view:cache\n\
php artisan migrate --force || true\n\
php artisan storage:link || true\n\
exec /usr/bin/supervisord -c /etc/supervisord.conf\n' > /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]