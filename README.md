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

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**

## Docker Development Environment

This project ships with a Docker-based stack to simplify local development and keep services aligned with production expectations.

### System Requirements

- Docker Engine or Docker Desktop 4.33+ (Compose v2 included)
- 4 CPU cores and ≥6 GB RAM allocated to Docker for smooth PHP + Node builds
- ~3 GB free disk space for images, MySQL, and Redis volumes

### Services

- `yukikoi-app` - FrankenPHP runtime serving Laravel from `/app/public`
- `yukikoi-reverb` - runs `php artisan reverb:start` (WebSocket server on port 8080)
- `yukikoi-scheduler` - runs `php artisan schedule:work`
- `yukikoi-worker` - processes Redis queue jobs
- `minio` - S3-compatible object storage for user uploads
- `imgproxy` - on-the-fly media transformer / CDN facade (exposed on `http://localhost:8090`)
- `redis` - Redis 7 with append-only persistence on volume `redis-data`
- `whatsapp-bot` - Node-based bot runner sharing the workspace

Note: We currently connect to a host MySQL (Laragon) instead of a MySQL container. The app uses `host.docker.internal:3306` from inside Docker.

### Usage

1. Copy `.env.example` to `.env` and adjust keys:
   - Non-Docker: `DB_HOST=127.0.0.1`, Docker: set via compose to `host.docker.internal`.
   - `REDIS_HOST=127.0.0.1` locally; Docker sets it to `redis` via compose.
   - For SMTP testing, set `MAIL_MAILER=smtp` and supply Mailtrap creds.
   - Do not commit secrets. `.env` is already in `.gitignore`.
2. Build and start the stack:
   ```bash
   docker compose up --build
   ```
3. Install PHP dependencies inside the `yukikoi-app` container (run once per clone):
   ```bash
   docker compose exec app composer install
   ```
4. Install JavaScript dependencies in the `whatsapp-bot` container:
   ```bash
   docker compose exec node-bot npm install
   ```
5. Run database migrations, seeders, or queue workers as needed, e.g.:
   ```bash
   docker compose exec app php artisan migrate
   docker compose exec app php artisan queue:work redis
   ```

### Docker vs Non-Docker hostnames

- Database: `127.0.0.1` (non-Docker) vs `host.docker.internal` (inside Docker).
- Redis: `127.0.0.1` (non-Docker) vs `redis` service name (inside Docker).

### Nginx config

- Nginx serves from `/var/www/html/public` to match the project volume mount.
- Config path: `docker/nginx/default.conf`. Restart with `docker compose restart nginx` after changes.

### Octane

- Octane is disabled by default when running via PHP-FPM + Nginx. To enable Octane, switch to an Octane-compatible runtime and update compose accordingly.

Redis is exposed on `localhost:6379` for debugging, the Laravel app is reachable at `http://localhost:8000`, MinIO serves files on `http://localhost:9000`, the MinIO console lives on `http://localhost:9001`, and Imgproxy is exposed at `http://localhost:8090`. Data for Postgres, Redis, and MinIO persists between restarts through the named volumes declared in `docker-compose.yml`.

### Redis caching

- Home page auctions and carousel ads are cached in Redis for `CACHE_TTL_HOME_AUCTIONS` / `CACHE_TTL_HOME_CAROUSEL_ADS` seconds (default 60) to reduce repeated queries.
- Cache keys: `home:auctions`, `home:carousel_ads` (see `App\Support\CacheKeys`).
- Any create/update/delete on `Auction` or `Ad` automatically clears the relevant cache via observers.
- Reverb and the scheduler are managed as first-class services, so `docker compose up -d` automatically starts websocket broadcasting and cron processing.
- Media uploads now land in MinIO (S3 compatible) using the `s3` filesystem disk. Imgproxy fronts all media access, generating fast, cacheable thumbnails.
- Requests hitting `/storage/...` are routed through Laravel and redirected to Imgproxy, so legacy Blade templates keep working.

### Object storage & Imgproxy setup

1. Copy `.env.example` to `.env` and adjust the `MINIO_*`, `AWS_*`, and `IMGPROXY_*` entries if you need custom credentials.
2. Build and start the new services:
   ```bash
   docker compose up -d --build app reverb scheduler worker minio imgproxy
   ```
3. Create the bucket once (defaults to `yukikoi-media`):
   ```bash
   docker run --rm --network yukikoi_app-network \
     --entrypoint="" minio/mc \
     mc alias set local http://minio:9000 minioadmin minioadmin123 && \
     mc mb local/yukikoi-media || true
   ```
   Adjust credentials if you changed them in `.env`.
4. Generate Imgproxy secrets (hex strings):
   ```bash
   openssl rand -hex 32  # use once for IMGPROXY_KEY
   openssl rand -hex 32  # use once for IMGPROXY_SALT
   ```
   Update `.env`, then restart Imgproxy: `docker compose up -d imgproxy`. Once keys are set, change `IMGPROXY_ALLOW_INSECURE_URLS=false`.
5. If you previously ran `php artisan storage:link`, remove the generated symlink (`rm public/storage`) so Laravel can proxy `/storage/{path}` requests.
6. Uploads and media responses automatically use the new stack. Existing Blade calls to `asset('storage/...')` continue to work via the `/storage/{path}` proxy route.
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
