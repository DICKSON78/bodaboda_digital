#!/bin/bash

# =============================================================================
# 🏍️ BodaBoda Digital - Installation Script
# =============================================================================
# This script installs and configures the entire BodaBoda Digital platform
# Author: BodaBoda Digital Team
# Version: 1.0.0
# =============================================================================

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# =============================================================================
# HELPER FUNCTIONS
# =============================================================================

print_header() {
    echo -e "${PURPLE}==============================================================================${NC}"
    echo -e "${PURPLE}$1${NC}"
    echo -e "${PURPLE}==============================================================================${NC}"
}

print_step() {
    echo -e "${BLUE}$1${NC}"
}

print_success() {
    echo -e "${GREEN} SUCCESS: $1${NC}"
}

print_error() {
    echo -e "${RED} ERROR: $1${NC}"
}

print_warning() {
    echo -e "${YELLOW} WARNING: $1${NC}"
}

print_info() {
    echo -e "${CYAN} INFO: $1${NC}"
}

# Check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Check if service is running
is_service_running() {
    if command_exists docker-compose; then
        docker-compose ps | grep -q "Up"
    elif command_exists docker; then
        docker compose ps | grep -q "Up"
    else
        return 1
    fi
}

# =============================================================================
# SYSTEM REQUIREMENTS CHECK
# =============================================================================

check_system_requirements() {
    print_header "Checking System Requirements"
    
    local requirements_met=true
    
    # Check PHP
    if command_exists php; then
        php_version=$(php -v | head -n 1 | cut -d " " -f 2 | cut -d "-" -f 1)
        print_success "PHP found: $php_version"
        
        # Check if PHP version is 8.2+
        if php -v | grep -q "PHP 8.[2-9]"; then
            print_success "PHP version meets requirements (8.2+)"
        else
            print_error "PHP 8.2+ required. Current: $php_version"
            requirements_met=false
        fi
    else
        print_error "PHP not found. Please install PHP 8.2+"
        requirements_met=false
    fi
    
    # Check Composer
    if command_exists composer; then
        composer_version=$(composer --version | cut -d " " -f 3)
        print_success "Composer found: $composer_version"
    else
        print_error "Composer not found. Please install Composer"
        requirements_met=false
    fi
    
    # Check MySQL/MariaDB
    if command_exists mysql; then
        mysql_version=$(mysql --version | cut -d " " -f 3 | cut -d "," -f 1)
        print_success "MySQL found: $mysql_version"
    elif command_exists mariadb; then
        mariadb_version=$(mariadb --version | cut -d " " -f 3 | cut -d "-" -f 1)
        print_success "MariaDB found: $mariadb_version"
    else
        print_warning "MySQL/MariaDB not found. Will use Docker database"
    fi
    
    # Check Docker
    if command_exists docker; then
        docker_version=$(docker --version | cut -d " " -f 3 | cut -d "," -f 1)
        print_success "Docker found: $docker_version"
        
        # Check Docker Compose
        if command_exists docker-compose || docker compose version >/dev/null 2>&1; then
            print_success "Docker Compose found"
        else
            print_error "Docker Compose not found"
            requirements_met=false
        fi
    else
        print_warning "Docker not found. Will install without Docker"
    fi
    
    # Check Node.js (optional)
    if command_exists node; then
        node_version=$(node --version)
        print_success "Node.js found: $node_version"
    else
        print_info "Node.js not found (optional for asset compilation)"
    fi
    
    # Check Git
    if command_exists git; then
        git_version=$(git --version | cut -d " " -f 3)
        print_success "Git found: $git_version"
    else
        print_error "Git not found. Please install Git"
        requirements_met=false
    fi
    
    if [ "$requirements_met" = false ]; then
        print_error "Some requirements are not met. Please install missing dependencies and try again."
        exit 1
    fi
    
    print_success "All system requirements met!"
}

# =============================================================================
# INSTALLATION OPTIONS
# =============================================================================

show_installation_options() {
    print_header "BodaBoda Digital Installation Options"
    
    echo -e "${CYAN}Choose installation method:${NC}"
    echo "1) Docker Installation (Recommended)"
    echo "2) Local Installation (Manual Setup)"
    echo "3) Development Setup (with dev tools)"
    echo "4) Exit"
    echo ""
    read -p "Enter your choice (1-4): " choice
    
    case $choice in
        1)
            docker_installation
            ;;
        2)
            local_installation
            ;;
        3)
            development_installation
            ;;
        4)
            print_info "Installation cancelled. Goodbye!"
            exit 0
            ;;
        *)
            print_error "Invalid choice. Please try again."
            show_installation_options
            ;;
    esac
}

# =============================================================================
# DOCKER INSTALLATION
# =============================================================================

docker_installation() {
    print_header "Docker Installation"
    
    print_step "Checking Docker services..."
    
    # Stop existing services if running
    if is_service_running; then
        print_warning "Existing Docker services detected. Stopping them..."
        if command_exists docker-compose; then
            docker-compose down
        else
            docker compose down
        fi
    fi
    
    print_step "Starting Docker services..."
    
    # Start services
    if command_exists docker-compose; then
        docker-compose up -d --build
    else
        docker compose up -d --build
    fi
    
    # Wait for services to be ready
    print_step "Waiting for services to be ready..."
    sleep 10
    
    # Check if services are running
    if is_service_running; then
        print_success "Docker services are running!"
        
        # Install Composer dependencies
        print_step "Installing Composer dependencies..."
        if command_exists docker-compose; then
            docker-compose exec app composer install --optimize-autoloader
        else
            docker compose exec app composer install --optimize-autoloader
        fi
        
        # Generate application key
        print_step "Generating application key..."
        if command_exists docker-compose; then
            docker-compose exec app php artisan key:generate
        else
            docker compose exec app php artisan key:generate
        fi
        
        # Run migrations
        print_step "Running database migrations..."
        if command_exists docker-compose; then
            docker-compose exec app php artisan migrate --force
        else
            docker compose exec app php artisan migrate --force
        fi
        
        # Seed database
        print_step "Seeding database..."
        if command_exists docker-compose; then
            docker-compose exec app php artisan db:seed --force
        else
            docker compose exec app php artisan db:seed --force
        fi
        
        # Create storage link
        print_step "Creating storage link..."
        if command_exists docker-compose; then
            docker-compose exec app php artisan storage:link
        else
            docker compose exec app php artisan storage:link
        fi
        
        # Optimize application
        print_step "Optimizing application..."
        if command_exists docker-compose; then
            docker-compose exec app php artisan config:cache
            docker-compose exec app php artisan route:cache
            docker-compose exec app php artisan view:cache
        else
            docker compose exec app php artisan config:cache
            docker compose exec app php artisan route:cache
            docker compose exec app php artisan view:cache
        fi
        
        print_success "Docker installation completed successfully!"
        
        # Start the development server and open browser
        print_step "Starting development server..."
        if command_exists docker-compose; then
            docker-compose exec app php artisan serve --host=0.0.0.0 --port=8000 &
        else
            docker compose exec app php artisan serve --host=0.0.0.0 --port=8000 &
        fi
        
        # Wait for server to start
        sleep 3
        
        # Open browser automatically
        print_step "Opening application in browser..."
        if command_exists xdg-open; then
            xdg-open http://localhost:8000
        elif command_exists open; then
            open http://localhost:8000
        elif command_exists start; then
            start http://localhost:8000
        else
            print_info "Please open http://localhost:8000 in your browser"
        fi
        
        show_access_info
        
    else
        print_error "Docker services failed to start. Please check the logs:"
        if command_exists docker-compose; then
            docker-compose logs
        else
            docker compose logs
        fi
        exit 1
    fi
}

# =============================================================================
# LOCAL INSTALLATION
# =============================================================================

local_installation() {
    print_header "Local Installation"
    
    # Check if .env file exists
    if [ ! -f ".env" ]; then
        print_step "Creating environment file..."
        cp .env.example .env
        
        # Generate key
        print_step "Generating application key..."
        php artisan key:generate
        
        print_info "Please edit the .env file with your database credentials before continuing."
        read -p "Press Enter to continue after editing .env file..."
    fi
    
    # Install dependencies
    print_step "Installing Composer dependencies..."
    composer install --optimize-autoloader
    
    # Create storage directories
    print_step "Creating storage directories..."
    mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
    chmod -R 775 storage bootstrap/cache
    
    # Run migrations
    print_step "Running database migrations..."
    php artisan migrate --force
    
    # Seed database
    print_step "Seeding database..."
    php artisan db:seed --force
    
    # Create storage link
    print_step "Creating storage link..."
    php artisan storage:link
    
    # Optimize application
    print_step "Optimizing application..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    print_success "Local installation completed successfully!"
    
    # Start the development server and open browser
    print_step "Starting development server..."
    php artisan serve --host=0.0.0.0 --port=8000 &
    
    # Wait for server to start
    sleep 3
    
    # Open browser automatically
    print_step "Opening application in browser..."
    if command_exists xdg-open; then
        xdg-open http://localhost:8000
    elif command_exists open; then
        open http://localhost:8000
    elif command_exists start; then
        start http://localhost:8000
    else
        print_info "Please open http://localhost:8000 in your browser"
    fi
    
    show_access_info
}

# =============================================================================
# DEVELOPMENT INSTALLATION
# =============================================================================

development_installation() {
    print_header "Development Installation"
    
    # Install dev dependencies
    print_step "Installing development dependencies..."
    composer install
    
    # Install Node.js dependencies if available
    if command_exists node && command_exists npm; then
        print_step "Installing Node.js dependencies..."
        npm install
        
        # Build assets
        print_step "Building assets..."
        npm run build
    fi
    
    # Copy environment file
    if [ ! -f ".env" ]; then
        print_step "Creating development environment file..."
        cp .env.example .env
        php artisan key:generate
    fi
    
    # Create storage directories
    print_step "Creating storage directories..."
    mkdir -p storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
    chmod -R 775 storage bootstrap/cache
    
    # Run migrations
    print_step "Running database migrations..."
    php artisan migrate
    
    # Seed database
    print_step "Seeding database..."
    php artisan db:seed
    
    # Create storage link
    print_step "Creating storage link..."
    php artisan storage:link
    
    print_success "Development installation completed successfully!"
    
    # Start the development server and open browser
    print_step "Starting development server..."
    php artisan serve --host=0.0.0.0 --port=8000 &
    
    # Wait for server to start
    sleep 3
    
    # Open browser automatically
    print_step "Opening application in browser..."
    if command_exists xdg-open; then
        xdg-open http://localhost:8000
    elif command_exists open; then
        open http://localhost:8000
    elif command_exists start; then
        start http://localhost:8000
    else
        print_info "Please open http://localhost:8000 in your browser"
    fi
    
    show_access_info
}

# =============================================================================
# ACCESS INFORMATION
# =============================================================================

show_access_info() {
    print_header "Installation Complete!"
    
    echo -e "${GREEN}BodaBoda Digital is now installed and ready to use!${NC}"
    echo ""
    
    if is_service_running; then
        echo -e "${CYAN}Application Access:${NC}"
        echo "   Web Application: http://localhost:8000"
        echo "   Admin Panel: http://localhost:8000/admin"
        echo "   Login: admin@bodaboda.co.tz / password"
        echo ""
        
        echo -e "${CYAN}Database Access:${NC}"
        echo "   MySQL: localhost:3306"
        echo "   User: bodaboda_user"
        echo "   Password: root"
        echo "   Database: bodaboda"
        echo ""
        
        echo -e "${CYAN}Docker Commands:${NC}"
        echo "   View logs: docker-compose logs -f"
        echo "   Stop services: docker-compose down"
        echo "   Restart services: docker-compose restart"
        echo "   Access shell: docker-compose exec app bash"
    else
        echo -e "${CYAN}Application Access:${NC}"
        echo "   Web Application: http://localhost:8000"
        echo "   Admin Panel: http://localhost:8000/admin"
        echo "   Login: admin@bodaboda.co.tz / password"
        echo ""
        
        echo -e "${CYAN}Start Application:${NC}"
        echo "   Run: php artisan serve"
        echo "   Access: http://localhost:8000"
    fi
    
    echo ""
    echo -e "${CYAN}Next Steps:${NC}"
    echo "   1. Read the README.md for detailed documentation"
    echo "   2. Configure your environment variables in .env"
    echo "   3. Create user accounts for testing"
    echo "   4. Run tests: php artisan test"
    echo "   5. Start developing your features!"
    echo ""
    
    echo -e "${PURPLE}==============================================================================${NC}"
    echo -e "${PURPLE}Thank you for choosing BodaBoda Digital!${NC}"
    echo -e "${PURPLE}==============================================================================${NC}"
}

# =============================================================================
# MAIN EXECUTION
# =============================================================================

main() {
    print_header "BodaBoda Digital Installation Script"
    
    # Check if we're in the right directory
    if [ ! -f "composer.json" ] || [ ! -d "app" ]; then
        print_error "Please run this script from the BodaBoda Digital project root directory"
        exit 1
    fi
    
    # Make script executable
    chmod +x "$0"
    
    # Check system requirements
    check_system_requirements
    
    # Show installation options
    show_installation_options
}

# Run main function
main "$@"