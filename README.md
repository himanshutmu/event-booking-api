# Event Booking API

A RESTful API for managing events, attendees, and bookings, built with Laravel 12 using the repository pattern.

## Features
- Create, update, delete, and list events.
- Create attendees.
- Book events with capacity and duplicate booking checks.
- Pagination for event listing.
- API documentation via Swagger.

## Requirements
- PHP >= 8.2
- Composer
- MySQL

## Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd event-booking-api
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Configure Environment**
   - Copy `.env.example` to `.env` and update database credentials.
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

4. **Run Migrations**
   ```bash
   php artisan migrate
   ```

5. **Install Swagger for API Documentation**
   ```bash
   php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
   php artisan l5-swagger:generate
   ```

6. **Run the Application**
   ```bash
   php artisan serve
   ```
   Access the API at `http://localhost:8000`. Swagger UI is available at `http://localhost:8000/api/documentation`.

## API Endpoints
- **Events**
  - `GET /api/events` - List events (paginated)
  - `POST /api/events` - Create event (authenticated)
  - `PUT /api/events/{id}` - Update event (authenticated)
  - `DELETE /api/events/{id}` - Delete event (authenticated)
- **Attendees**
  - `POST /api/attendees` - Register attendee
- **Bookings**
  - `POST /api/bookings` - Book an event

## Authentication
- Uses Laravel Sanctum for token-based authentication.
- Event management routes require authentication (`auth:sanctum` middleware).
- Attendee registration and booking are public.

## Testing
Run tests using:
```bash
php artisan test
```

## Project Structure
- `app/Http/Controllers` - API controllers.
- `app/Repositories` - Repository interfaces and implementations.
- `app/Http/Requests` - Form request validation.
- `tests` - feature tests.

## Bonus Features
- **Pagination**: Event listing supports pagination (`per_page` and `page` query parameters).
- **Swagger**: API documentation available at `/api/documentation`.