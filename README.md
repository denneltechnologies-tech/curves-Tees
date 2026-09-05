# Streetman Cafe & Flames — Authentic Street Food Ordering System

A full-stack e-commerce and food ordering system for **Streetman Cafe & Flames** with three parts:

- **repo root (Laravel)** — Laravel 12 + Sanctum REST API **and** a Laravel Blade admin dashboard
- **`mobile/`** — Expo SDK 57 (React Native) customer mobile app with Expo Router
- **`docs/`** — API reference (`API.md`) and deployment guide (`DEPLOYMENT.md`)

---

## Brand Identity

- **Name**: Streetman Cafe & Flames
- **Tagline**: *"Taste the Street, Love the Flavor."*
- **Motto**: *"Good Food. Good Mood. Streetman!"*
- **Order Hotline**: `0546441987`
- **Socials**: `@streetman_foods` (Facebook, Instagram, TikTok)
- **Currency**: Ghana Cedis (`GH₵`)

---

## Stack

| Layer     | Technology                                                        |
|-----------|-------------------------------------------------------------------|
| Backend   | Laravel 12.68, Sanctum 4.3.3, PHP 8.2                             |
| Database  | SQLite (local dev) / MySQL 8 (Production)                         |
| Admin UI  | Laravel Blade (server-rendered at `/admin/login`)                 |
| Mobile    | Expo SDK 57, React Native 0.86, React 19, Expo Router, Zustand, axios |

---

## Menu & Offerings

### 1. Rice Meals
- **Fried Rice (1 Chicken + 2 Sausages)** — `GH₵ 40.00`
- **Jollof Rice (1 Chicken + 2 Sausages)** — `GH₵ 45.00`
- **Fried Rice or Jollof Rice (1 Chicken)** — `GH₵ 30.00`
- **Egg Fried Rice (1 Chicken + 2 Sausages)** — `GH₵ 50.00`
- **Egg Jollof Rice (1 Chicken + 2 Sausages)** — `GH₵ 55.00`
- **Assorted Fried Rice (1 Chicken + Plantain)** — `GH₵ 55.00`
- **Assorted Jollof Rice (1 Chicken + Plantain)** — `GH₵ 60.00`

### 2. Streetman Combos & Fries
- **Streetman Style - Milk & Fries Combo** — `GH₵ 65.00`
- **Fries (1 Chicken + 2 Sausages)** — `GH₵ 35.00`

### 3. Drinks & Extras
- **Milkshake** — `GH₵ 40.00`
- **Boba** — `GH₵ 50.00`
- **Soft Drink** — `GH₵ 8.00`
- **Bottled Water** — `GH₵ 5.00`
- **Spring Rolls (3 Pcs)** — `GH₵ 10.00`

---

## Local Setup (Windows)

### Backend (Laravel at repo root)

```bash
# from repo root
copy .env.example .env

composer install
php artisan key:generate
# ensure database/database.sqlite exists
php artisan migrate:fresh --seed
php artisan serve
```

Default super-admin:
- email: `admin@streetman.com`
- password: `password`

### Mobile (Expo)

```bash
cd mobile
npm install
npx expo start
```
