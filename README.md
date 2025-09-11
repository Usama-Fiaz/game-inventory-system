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

### With Docker

```bash
git clone <repository-url>
cd ValorByte
docker compose up --build -d
docker compose exec backend php artisan migrate --force
```

Access:
- Frontend: http://localhost:3000
- Backend: http://localhost:8000

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
