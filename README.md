<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How to run

1. Clone the repository
2. cd to the cloned repository
3. Copy environment file:

```bash
cp .env.example .env
```

4. Start Docker containers:

```bash
docker-compose up -d
```

4. Install dependencies:

```bash
docker-compose exec app composer install
```

5. Generate application key:

```bash
docker-compose exec app php artisan key:generate
```

6. Run database migrations:

```bash
docker-compose exec app php artisan migrate
```

7. Access the application at http://localhost:3000/login

8. Example login : "admin@example.com" / "password123"

### Useful commands

-   Stop containers:

```bash
docker-compose down
```

-   View logs:

```bash
docker-compose logs -f
```
