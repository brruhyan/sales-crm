<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Deploy with Docker

This application is a Laravel/Filament application and should be deployed as a
PHP container, not as a Vercel Node.js project.

### Local or single-server deployment

1. Install Docker and Docker Compose.
2. Create the environment file:

   ```bash
   cp .env.example .env
   ```

   On Windows PowerShell, use `Copy-Item .env.example .env`.
3. Edit `.env` and set a unique `APP_KEY`, production `APP_URL`, database
   credentials, and `APP_DEBUG=false`. `DB_HOST` must be `db` when using the
   included Compose file:

   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.example
   DB_HOST=db
   DB_DATABASE=sales_maralabs
   DB_USERNAME=sales
   DB_PASSWORD=use-a-long-password
   DB_ROOT_PASSWORD=use-a-different-long-password
   ```

   Generate an application key with:

   ```bash
   docker compose run --rm app php artisan key:generate --show
   ```

   Copy the returned value into `APP_KEY`.
4. Build and start the containers:

   ```bash
   docker compose up -d --build
   ```
5. Run the database migrations and publish the upload link:

   ```bash
   docker compose exec app php artisan migrate --force
   docker compose exec app php artisan storage:link
   docker compose exec app php artisan optimize
   ```

The application is available at `http://localhost:8080`. The database and
uploaded files are stored in Docker volumes, so the application source is not
bind-mounted over the built `vendor` and `public/build` directories.

### Production requirements

- Put a reverse proxy or load balancer in front of port 80 and terminate TLS
  there.
- Run a separate worker for database-backed jobs:

  ```bash
  docker compose exec -d app php artisan queue:work --tries=3
  ```

- Back up the `db_data` and `storage_data` volumes.
- For multiple application replicas, use S3-compatible storage instead of the
  local `public` disk and run queue workers as a separate service.

## Deploy the Docker image on Vercel

Vercel supports HTTP containers using a root-level `Dockerfile.vercel`.
The included [`Dockerfile.vercel`](./Dockerfile.vercel) starts Laravel's
HTTP server on Vercel's `$PORT`.

Vercel does not run the included `docker-compose.yml`, MySQL container, or
Docker volumes. Before deploying, provision these services separately:

- An external MySQL-compatible database
- S3-compatible object storage for uploads and generated files
- A queue service or a separate worker host if background jobs are required

In Vercel:

1. Import this repository.
2. Leave the project root as the repository root.
3. Use the default Dockerfile detection. Do not set a Node/Vite build command.
4. Add the production environment variables under **Settings > Environment
   Variables**, including `APP_KEY`, `APP_URL`, `DB_*`, and the storage
   provider variables.
5. Deploy.

At minimum, set:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-project.vercel.app
APP_KEY=base64:your-generated-key

DB_CONNECTION=mysql
DB_HOST=your-external-database-host
DB_PORT=3306
DB_DATABASE=your-database
DB_USERNAME=your-user
DB_PASSWORD=your-password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=s3
```

Run migrations from a machine that has the repository and the production
database credentials:

```bash
php artisan migrate --force
```

Do not use the local `public` disk for production Vercel uploads: container
filesystem changes are not durable between instances or deployments. Configure
the `s3` disk with `AWS_*` variables instead.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
