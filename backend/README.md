# ONLINE CINEMA API

# Installation

1. `cd backend`
2. `composer i`
3. Create `.env` file and copy data from `.env.example`
4. Configure `APP_URL` and database credentials
5. `php artisan key:generate`
6. `php artisan migrate`
7. `php artisan storage:link`
8. Set up your web server (nginx or apache) or run `php artisan serve` for local development

# API Documentation

## Authentication

User authentication endpoints including login, registration, and logout.

<details>
<summary><strong>POST /api/login</strong></summary>

**Description:** Authenticate user and receive access token

**Request:**
```json
{
    "name": "Dmitriy"
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password",
}
```

**Response:**
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "two_factor": false
}
```
</details>

<details>
<summary><strong>POST /api/register</strong></summary>

**Description:** Register new user account

**Request:**
```json
{
    "name": "User",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

**Response:**
```json
{
    "message": "Registration successful."
}
```
</details>

<details>
<summary><strong>POST /api/logout</strong></summary>

**Description:** Logout user and invalidate token

**Requirement:** Bearer Token

**Response:**
```json
{
    "message": "Logout successful."
}
```
</details>

<details>
<summary><strong>POST /api/user</strong></summary>

**Description:** User profile info

**Requirement:** Bearer Token

**Response:**
```json
{
    "id":2,
    "name":"Alex",
    "email":"user@example.com",
    "email_verified_at":null,
    "created_at":"2026-01-10T11:08:22.000000Z",
    "updated_at":"2026-01-10T11:08:22.000000Z",
    "two_factor_secret":null,
    "two_factor_recovery_codes":null,
    "two_factor_confirmed_at":null
}
```
</details>
