# ONLINE CINEMA API

This is a simple online cinema API. Created this API with pattern Controller-Service-Repository.

# INSTALLATION

1. cd backend
2. composer i
3. Create .env and copy data from .env.example
4. Set up APP_URL and DATABASE data
5. php artisan key:generate
6. php artisan migrate
7. php artisan storage:link
8. Set up your web server (nginx or apache) or run php artisan serve (for local development)