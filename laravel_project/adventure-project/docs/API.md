# AdventureX API Documentation

## Base URL

```
https://adventurex.com/api
```

## Authentication

All API requests except `/api/login` require a Bearer token.

```http
Authorization: Bearer {token}
```

---

## Endpoints

### POST /api/login

Authenticate a user and receive an API token.

**Request:**
```json
{
    "email": "user@example.com",
    "password": "password"
}
```

**Response:**
```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com"
    },
    "token": "1|abc123..."
}
```

---

### POST /api/logout

Revoke the current API token.

**Headers:**
```http
Authorization: Bearer {token}
```

**Response:**
```json
{
    "message": "Logged out"
}
```

---

### GET /api/adventures

Get a paginated list of adventures.

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Mountain Hiking",
            "price": 300,
            "category": "Hiking"
        }
    ]
}
```

---

### POST /api/bookings

Create a new booking (authenticated).

**Headers:**
```http
Authorization: Bearer {token}
```

**Request:**
```json
{
    "adventure_id": 1,
    "booking_date": "2026-08-15",
    "participants": 2
}
```

**Response:**
```json
{
    "message": "Booking created successfully via API",
    "booking": {
        "id": 1,
        "adventure_id": 1,
        "booking_date": "2026-08-15",
        "participants": 2,
        "status": "pending"
    }
}
```

---

## Error Responses

```json
{
    "message": "Invalid credentials"
}
```

## Rate Limiting

API is rate limited to 60 requests per minute per IP.
