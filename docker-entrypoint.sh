#!/usr/bin/env sh
set -e

if [ "$DB_CONNECTION" = "mysql" ] || [ -n "$DB_HOST" ] || [ -n "$DB_URL" ]; then
  echo "Waiting for database ..."
  i=0
  until php -r '
    $url = getenv("DB_URL");
    $host = getenv("DB_HOST");
    $port = getenv("DB_PORT") ?: 3306;
    if ($url) {
      $p = parse_url($url);
      $host = $p["host"] ?? $host;
      $port = $p["port"] ?? $port;
      $user = $p["user"] ?? getenv("DB_USERNAME");
      $pass = isset($p["pass"]) ? urldecode($p["pass"]) : getenv("DB_PASSWORD");
      $db = ltrim($p["path"] ?? "", "/");
    } else {
      $user = getenv("DB_USERNAME");
      $pass = getenv("DB_PASSWORD");
      $db = getenv("DB_DATABASE");
    }
    new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
  ' >/dev/null 2>&1; do
    i=$((i+1))
    if [ "$i" -gt 120 ]; then
      echo "ERROR: database not reachable after 120s." >&2
      exit 1
    fi
    sleep 1
  done
  echo "Database ready."
else
  touch database/database.sqlite 2>/dev/null || true
fi

# Ensure storage directories exist and are writable
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force --no-interaction
fi

# Always run database migrations and seeders so the app is always functional
echo "Running database migrations..."
php artisan migrate --force --no-interaction || true

echo "Ensuring catalog, admin users, and lookbook are seeded..."
php artisan db:seed --force --no-interaction || true

php artisan storage:link 2>/dev/null || true

exec "$@"