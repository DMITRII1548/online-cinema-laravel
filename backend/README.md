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
<summary><strong>GET /api/user</strong></summary>

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

## Movie

Movie CRUD endpoints

<details>
<summary><strong>GET /api/movies?page=1</strong></summary>

**Description:** Get paginated movies

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "title": "nobis",
            "description": "Sapiente et tenetur omnis quae consequatur exercitationem. Illo enim ut doloremque quaerat dolores. Quod et autem optio assumenda molestiae maxime.",
            "image": "http://127.0.0.1:8000/storage/C:\\Users\\USER\\AppData\\Local\\Temp\\fak3A03.tmp",
            "video": {
                "id": 1,
                "video": "http://127.0.0.1:8000/storage/C:\\Users\\USER\\AppData\\Local\\Temp\\fak3A14.tmp"
            }
        },
        ...
    ]
    "current_page": 1,
    "last_page": 5
}
```
</details>

<details>
<summary><strong>GET /api/movies/:id</strong></summary>

**Description:** Get a full movie info with a video

**Response:**
```json
{
    "id": 1,
    "title": "nobis",
    "description": "Sapiente et tenetur omnis quae consequatur exercitationem. Illo enim ut doloremque",
    "image": "http://127.0.0.1:8000/storage/C:\\Users\\USER\\AppData\\Local\\Temp\\fak3A03.tmp",
    "video": {
        "id": 1,
        "video": "http://127.0.0.1:8000/storage/C:\\Users\\USER\\AppData\\Local\\Temp\\fak3A14.tmp"
    }
}
```
</details>

<details>
<summary><strong>POST /api/movies</strong></summary>

**Description:** Create a new movie

**Requirement:** Bearer Token and Admin Role

**Request:**
```json
{
    "title": "Some title",
    "description: "Some description",
    "image": File|Image,
    "video_id": 1
}
```

**Response:**
```json
{
    "data": {
        "id": 101,
        "title": "\"Example\"",
        "description": "\"Lorem ipsum\"",
        "image": "http://127.0.0.1:8000/storage/images/SXqaOSXUjuommNE9UVeoDFndD8uDZu6vlljFcGEg.png",
        "video": {
            "id": 1,
            "video": "http://127.0.0.1:8000/storage/C:\\Users\\USER\\AppData\\Local\\Temp\\fak3A14.tmp"
        }
    }
}
```
</details>

<details>
<summary><strong>POST /api/movies/:id</strong></summary>

**Description:** Update a movie

**Requirement:** Bearer Token and Admin Role

**Request:**
```json
{
    "title": "Some title",
    "description: "Some description",
    "image": File|Image,
    "video_id": 1
}
```

**Response:**
```json
{
    "updated":true
}
```
</details>

<details>
<summary><strong>DELETE /api/movies/:id</strong></summary>

**Description:** Delete a movie

**Requirement:** Bearer Token and Admin Role

**Response:**
```json
{
    "message":"Deleted movie successful"
}
```
</details>
