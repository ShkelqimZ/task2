# Docker Setup for SHZ Task Laravel Application

This Laravel application is fully containerized using Docker Compose for easy development and deployment.

## Quick Start

Simply run:

```bash
docker-compose up --build
```

The application will be available at: **http://localhost:8000**

## Services Overview

The Docker setup includes the following services:

- **app**: PHP 8.2-FPM Laravel application
- **nginx**: Web server (port 8000)
- **db**: MySQL 8.0 database (port 3306)
- **redis**: Redis cache and session store (port 6379)
- **init**: One-time setup service for Laravel initialization
- **queue**: Background job processor
- **scheduler**: Laravel task scheduler
- **node**: Frontend asset compilation

## First Time Setup

1. **Clone and navigate to the project:**
   ```bash
   git clone <repository-url>
   cd task2
   ```

2. **Start the application:**
   ```bash
   docker-compose up --build
   ```

3. **Wait for initialization:**
   The `init` service will automatically:
   - Copy `.env.example` to `.env`
   - Generate application key
   - Run database migrations
   - Seed the database
   - Cache configurations

4. **Access the application:**
   Open http://localhost:8000 in your browser

## Development Workflow

### Starting the Application

```bash
# Start all services
docker-compose up

# Start in background
docker-compose up -d

# Start with rebuild
docker-compose up --build
```

### Stopping the Application

```bash
# Stop all services
docker-compose down

# Stop and remove volumes
docker-compose down -v
```

### Running Artisan Commands

```bash
# Run migrations
docker-compose exec app php artisan migrate

# Create seeder
docker-compose exec app php artisan make:seeder ExampleSeeder

# Clear cache
docker-compose exec app php artisan cache:clear

# Generate key
docker-compose exec app php artisan key:generate
```

### Running Composer Commands

```bash
# Install dependencies
docker-compose exec app composer install

# Add package
docker-compose exec app composer require package-name

# Update packages
docker-compose exec app composer update
```

### Running NPM Commands

```bash
# Install dependencies
docker-compose exec node npm install

# Build assets
docker-compose exec node npm run build

# Watch for changes (development)
docker-compose exec node npm run dev
```

### Database Access

```bash
# Connect to MySQL
docker-compose exec db mysql -u root -p task2
# Password: password

# Run database commands
docker-compose exec app php artisan migrate:fresh --seed
```

### Viewing Logs

```bash
# All services
docker-compose logs

# Specific service
docker-compose logs app
docker-compose logs nginx
docker-compose logs queue

# Follow logs
docker-compose logs -f app
```

## Environment Configuration

The application uses these environment variables (configured in `docker-compose.yml`):

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=task2
DB_USERNAME=root
DB_PASSWORD=password

REDIS_HOST=redis
REDIS_PORT=6379

QUEUE_CONNECTION=redis
CACHE_STORE=redis
SESSION_DRIVER=redis

MAIL_MAILER=log
```

## Port Mappings

- **8000**: Nginx web server
- **3306**: MySQL database
- **6379**: Redis cache

## Troubleshooting

### Container Issues

```bash
# Rebuild containers
docker-compose build --no-cache

# Remove all containers and volumes
docker-compose down -v
docker system prune -a

# Check container status
docker-compose ps

# Inspect specific container
docker-compose logs <service-name>
```

### Permission Issues

```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chmod -R 775 /var/www/storage
```

### Database Issues

```bash
# Reset database
docker-compose exec app php artisan migrate:fresh --seed

# Check database connection
docker-compose exec app php artisan tinker
# >>> DB::connection()->getPdo();
```

### Queue Issues

```bash
# Restart queue worker
docker-compose restart queue

# Clear failed jobs
docker-compose exec app php artisan queue:clear
```

## File Structure

```
task2/
├── docker/
│   ├── app/
│   │   ├── Dockerfile          # PHP application container
│   │   └── php.ini            # PHP configuration
│   ├── nginx/
│   │   └── default.conf       # Nginx configuration
│   └── init-project.sh        # Laravel initialization script
├── docker-compose.yml         # Docker Compose configuration
├── .dockerignore              # Docker ignore file
└── .env.example              # Environment variables template
```

## Production Considerations

For production deployment:

1. **Update environment variables:**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Use strong passwords
   - Configure proper mail settings

2. **Use environment files:**
   ```bash
   docker-compose --env-file .env.production up -d
   ```

3. **Enable SSL/HTTPS:**
   - Configure SSL certificates in Nginx
   - Update `APP_URL` to use HTTPS

4. **Optimize containers:**
   - Use multi-stage builds
   - Remove development dependencies
   - Optimize image sizes

## Useful Commands

```bash
# Full application reset
docker-compose down -v && docker-compose up --build

# Access container shell
docker-compose exec app bash

# Monitor resource usage
docker stats

# Export database
docker-compose exec db mysqldump -u root -p task2 > backup.sql

# Import database
docker-compose exec -T db mysql -u root -p task2 < backup.sql
``` 