#!/bin/bash

echo "Starting SHZ Task Laravel Application..."
echo "========================================"

# Check if Docker and Docker Compose are installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

# Start the application
echo "🚀 Starting the application with docker-compose up --build..."
docker-compose up --build

echo ""
echo "✅ Application should be available at: http://localhost:8000"
echo "📊 Database: MySQL on localhost:3306 (user: root, password: password)"
echo "🗂️  Redis: localhost:6379"
echo ""
echo "To stop the application, press Ctrl+C or run: docker-compose down" 