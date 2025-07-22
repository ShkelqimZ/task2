# SHZ Task - Laravel Library Management System

A Laravel-based library management system with book lending, member management, and overdue notification features.

## 🚀 Quick Start with Docker

The easiest way to run this application is using Docker Compose:

```bash
docker-compose up --build
```

Or use the convenience script:

```bash
./start.sh
```

**The application will be available at: http://localhost:8000**

## 📋 Prerequisites

- Docker
- Docker Compose

## 🏗️ What's Included

This application includes:

- **Book Management**: Add, edit, and manage library books
- **Member Management**: Handle library member registrations
- **Loan System**: Track book borrowing and returns
- **Overdue Notifications**: Automated email reminders for overdue books
- **Queue System**: Background job processing for emails
- **API Endpoints**: RESTful API for all operations

## 🐳 Docker Services

The Docker setup includes:

- **PHP 8.2** with Laravel 12
- **Nginx** web server (port 8000)
- **MySQL 8.0** database (port 3306)
- **Redis** for caching and queues (port 6379)
- **Queue Worker** for background jobs
- **Task Scheduler** for automated tasks
- **Node.js** for asset compilation

## 📚 Project Structure

```
task2/
├── app/
│   ├── Http/Controllers/     # API Controllers
│   ├── Models/              # Eloquent Models (Book, Member, Loan)
│   ├── Services/            # Business Logic Services
│   ├── Mail/                # Email Templates
│   └── Console/Commands/    # Artisan Commands
├── database/
│   ├── migrations/          # Database Schema
│   ├── seeders/            # Sample Data
│   └── factories/          # Model Factories
├── routes/
│   └── api.php             # API Routes
├── docker/                 # Docker Configuration
└── tests/                  # Feature & Unit Tests
```

## 🔧 Development

### Running Commands

```bash
# Laravel Artisan commands
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan make:controller ExampleController

# Composer commands
docker-compose exec app composer install
docker-compose exec app composer require package-name
```

### Database Access

```bash
# Connect to MySQL
docker-compose exec db mysql -u root -p task2
# Password: password
```

### Viewing Logs

```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
docker-compose logs -f queue
```

## 🧪 Testing

Run the test suite:

```bash
docker-compose exec app php artisan test
```

## 📝 API Endpoints

### Books
- `GET /api/books` - List all books

### Loans
- `POST /api/loans` - Create a new loan
- `PUT /api/loans/{id}/return` - Mark loan as returned

## 🔧 Configuration

### Environment Variables

Key environment variables (configured in `docker-compose.yml`):

```env
APP_URL=http://localhost:8000
DB_HOST=db
DB_DATABASE=task2
REDIS_HOST=redis
QUEUE_CONNECTION=redis
MAIL_MAILER=log
```

### Database

- **Host**: localhost (or `db` from containers)
- **Port**: 3306
- **Database**: task2
- **Username**: root
- **Password**: password

## 📧 Email System

The application includes an email system for overdue loan notifications:

- Emails are logged by default (check Laravel logs)
- Queue system processes emails in the background
- Scheduler runs the overdue email command daily

To send overdue notifications manually:

```bash
docker-compose exec app php artisan loans:send-overdue-emails
```

## 🛠️ Troubleshooting

### Common Issues

1. **Port conflicts**: Change ports in `docker-compose.yml` if 8000, 3306, or 6379 are in use
2. **Permission issues**: Run `docker-compose exec app chown -R www-data:www-data /var/www/storage`
3. **Database connection**: Ensure MySQL container is healthy before app starts
4. **Asset compilation**: Run `docker-compose exec node npm run build` for frontend assets

### Full Reset

```bash
# Stop everything and remove volumes
docker-compose down -v

# Rebuild and restart
docker-compose up --build
```
