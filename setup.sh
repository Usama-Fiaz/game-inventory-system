#!/bin/bash

echo "🚀 Setting up ValorByte..."

echo "Stopping existing containers..."
docker compose down

echo "Removing old data..."
docker compose down -v

echo "Building and starting containers..."
docker compose up --build -d

echo "Waiting for services to start..."
sleep 10

echo "Checking service status..."
docker compose ps

echo "Setup complete!"
echo ""
echo "Access your application:"
echo "  Frontend: http://localhost:3000"
echo "  Backend:  http://localhost:8000"
echo ""
echo "To view logs: docker compose logs -f"
echo "To stop:      docker compose down"
