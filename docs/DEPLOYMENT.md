# Streetman Cafe & Flames — Deployment Guide (Railway)

This guide covers deploying the **Laravel backend + Blade admin portal** to [Railway](https://railway.app)
using the bundled Dockerfile, and building the Expo mobile app with EAS.

- `APP_ENV=production`, `APP_DEBUG=false`
- **MySQL** database provided by a Railway MySQL plugin
- All secrets via Railway environment variables, never committed
- The mobile app is **not** deployed to Railway — it is a customer app published via EAS (App Store / Play Store)

---

## 1. Repo layout

```
streetman-app/                # Laravel at the repo root
├── app/  bootstrap/  config/  database/  public/  routes/  ...   # Laravel backend + Blade admin
├── mobile/                   # Expo SDK 57 (React Native) customer app
├── docs/                     # This guide + API reference
├── Dockerfile                # Railway build (PHP 8.3 + Composer)
├── railway.json              # Railway deployment config
└── docker-entrypoint.sh      # Waits for DB, runs migrations + seeders on boot
```

---

## 2. Push to GitHub

1. Create a repo (e.g. `streetman-app`) under your GitHub account.
2. From the repo root:

```bash
git remote add origin https://github.com/<your-account>/streetman-app.git
git branch -M master
git push -u origin master
```

3. Connect that repo to Railway: **New Project → Deploy from GitHub repo** → pick `streetman-app`.

---

## 3. Railway services

Create two services in the project:

| Service         | Kind         | Purpose                              |
|-----------------|--------------|--------------------------------------|
| `streetman-app` | GitHub repo  | Runs the Dockerfile (Laravel app)    |
| `streetman-mysql` | Database → MySQL | Persists orders/products/customers |

### 3.1 Add the MySQL database

In Railway: **New → Database → MySQL**. Railway exposes a connection string such as:

```
mysql://app:password@interal-host:3306/app
```

Railway automatically injects this as `MYSQL_URL` **or** `DATABASE_URL` **or** `DB_URL` depending on
naming. Our `docker-entrypoint.sh` already parses **`DB_URL`**. If your plugin exposes a different
variable name, add a Railway variable `DB_URL` = the connection string (or map it).

### 3.2 App environment variables

Set these on the **app service** (Railway → Variables):

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:<run `php artisan key:generate --show` locally once>   # or set via Railway/generate
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}   # set in railway.json, may show as literal in dashboard

DB_CONNECTION=mysql
DB_URL=<from the MySQL plugin, e.g. mysql://app:pass@host:3306/app>    # or DB_HOST/DB_PORT/DB_DATABASE/DB_USERNAME/DB_PASSWORD individually

QUEUE_CONNECTION=sync
SESSION_DRIVER=database
CACHE_STORE=database
FILESYSTEM_DISK=local

RUN_MIGRATIONS=true

# Admin web dashboard seeder credentials
ADMIN_EMAIL=admin@streetman.com
ADMIN_PASSWORD=change-me-now

# Paystack (used only when payments are configured)
PAYSTACK_PUBLIC_KEY=
PAYSTACK_SECRET_KEY=
PAYSTACK_BASE_URL=https://api.paystack.co

# Optional Expo push access token (Expo Push API)
EXPO_ACCESS_TOKEN=
```

> `railway.json` ships sensible defaults; simply add `DB_URL` and your secrets.

---

## 4. Deploy

Railway builds the Dockerfile and runs `docker-entrypoint.sh`, which:

1. Waits for MySQL to become reachable (parses `DB_URL` or `DB_HOST`).
2. Runs `php artisan migrate --force`.
3. Runs `php artisan db:seed --force` (creates the admin + categories + products).

Ready when the **healthcheck** passes: `GET /api/v1/products` → `200` JSON.

### Confirm

- `https://<your-app>.up.railway.app/api/v1/products` returns JSON.
- `https://<your-app>.up.railway.app/admin/login` loads the dashboard.

---

## 5. Mobile app build (EAS)

The mobile app talks to the backend via `EXPO_PUBLIC_API_URL`.

### 5.1 Set the API URL

```bash
cd mobile
```

Edit `mobile/.env` (this file is git-ignored) and `mobile/eas.json` preview env:

```dotenv
EXPO_PUBLIC_API_URL=https://<your-app>.up.railway.app
```

### 5.2 Build

```bash
cd mobile
npm install
npx eas login
npx eas build:configure
npx eas build --platform android --profile production
npx eas build --platform ios --profile production   # requires Apple Developer account
```

### 5.3 Push notifications

Push uses **Expo push tokens** (`ExpoPushToken[...]`), which require:

- `expo-notifications` (already included)
- A physical device or emulator — push tokens do not work on the Expo web/Go mock
- Android: `projectId` from `app.json` → `extra.eas.projectId` (set automatically by `eas build:configure`)

Devices call `POST /api/v1/device-tokens` (with `{ token }`) which the backend uses to send
notifications via the Expo Push API.

---

## 6. Production checklist

- [ ] `APP_DEBUG=false`
- [ ] MySQL plugin added and `DB_URL` (or individual DB vars) set
- [ ] `APP_KEY` set to a real key (not shared)
- [ ] Admin password changed after first login
- [ ] Backend reachable at `https://<your-app>.up.railway.app`
- [ ] Mobile `EXPO_PUBLIC_API_URL` points to the Railway backend
- [ ] HTTPS enforced (Railway supplies TLS automatically for `*.up.railway.app`)