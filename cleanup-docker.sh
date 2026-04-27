#!/bin/bash

# Docker container cleanup script for bodaboda-digital
# This script cleans up temporary files and logs to free disk space

echo "Cleaning up Docker container..."

# Clean Laravel logs
docker exec --user root bodaboda-app truncate -s 0 /var/www/storage/logs/laravel.log 2>/dev/null || true

# Clean PHP session files
docker exec --user root bodaboda-app find /var/lib/php -type f -name "sess_*" -delete 2>/dev/null || true

# Clean temp files
docker exec --user root bodaboda-app find /tmp -type f -name "*.php*" -delete 2>/dev/null || true

# Clean cache
docker exec --user root bodaboda-app rm -rf /var/www/storage/framework/cache/* 2>/dev/null || true
docker exec --user root bodaboda-app rm -rf /var/www/storage/framework/views/* 2>/dev/null || true

# Show disk space after cleanup
echo "Disk space after cleanup:"
docker exec bodaboda-app df -h

echo "Cleanup completed!"
