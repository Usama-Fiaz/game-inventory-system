# ValorByte - Game Inventory Manager

## Tech Stack

**Backend:**
- Laravel
- PostgreSQL
- Redis
- RabbitMQ
- gRPC

**Frontend:**
- React
- Redux
- TailwindCSS

**Infrastructure:**
- Docker

## Features

- Add, view, edit, delete game items
- Redis caching for performance
- RabbitMQ event publishing
- gRPC service for item retrieval
- Responsive React UI

## How to Run

### With Docker (Recommended)

```bash
git clone https://github.com/Usama-Fiaz/game-inventory-system.git
cd game-inventory-system
docker compose up --build -d
```

The setup will automatically:
- Build and start all services (PostgreSQL, Redis, RabbitMQ, Backend, Frontend)
- Run database migrations
- Start the Laravel server

Access:
- Frontend: http://localhost:3000
- Backend API: http://localhost:8000/api/items
- RabbitMQ Management: http://localhost:15672 (admin/admin)

### Without Docker

**Backend:**
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve --port=8000
```

**Frontend:**
```bash
cd frontend
npm install
npm start
```

**External Services (install separately):**
- PostgreSQL on localhost:5432
- Redis on localhost:6379
- RabbitMQ on localhost:5672

## API Endpoints

- `GET /api/items` - List all items
- `POST /api/items` - Create new item
- `PUT /api/items/{id}` - Update item
- `DELETE /api/items/{id}` - Delete item
- `gRPC GetItemById` - Get item by ID

## Project Structure

```
ValorByte/
├── backend/
├── frontend/ 
└── docker-compose.yml
```
