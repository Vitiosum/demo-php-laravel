# RunRank Laravel — Race pace calculator on Clever Cloud

> A Laravel 12 app that calculates your running pace and assigns a League of Legends–style rank. Deployed on Clever Cloud's PHP runtime.

---

## Deploy on Clever Cloud

1. Fork this repository
2. In the Clever Cloud console, create a new **PHP** application — connect your forked repo
3. No add-on needed (stateless, cookie-based sessions)
4. The `.env` file is committed — no manual environment variables to set
5. Push → Clever Cloud deploys automatically

**Configuration file:** `clevercloud/php.json`

```json
{ "deploy": { "webroot": "/public" } }
```

---

## Stack

| Layer     | Technology       |
|-----------|------------------|
| Language  | PHP 8.2          |
| Framework | Laravel 12       |
| Templates | Blade            |
| Sessions  | Cookie driver    |
| Design    | Track Night (Bebas Neue, orange #FF5A1F, dark background) |

---

## Features

- Running pace calculator (distance + time → min/km)
- Rank assignment from Iron to Challenger (League of Legends–style tiers)
- Track Night design system — full dark UI with orange accents
- Stateless — no database required

---

## Local Development

### Prerequisites

- PHP 8.2+
- Composer

### Run

```bash
git clone https://github.com/Vitiosum/demo-php-laravel
cd demo-php-laravel
composer install
php artisan serve
# → http://localhost:8000
```

---

## Environment Variables

| Variable         | Required | Description                                      |
|------------------|----------|--------------------------------------------------|
| `APP_KEY`        | auto     | Pre-set in committed `.env`                      |
| `SESSION_DRIVER` | auto     | Set to `cookie` in committed `.env`              |

No variables need to be set manually.

---

## Deployment Notes

- `clevercloud/php.json` sets the web root to `/public` — required for Laravel on Clever Cloud
- `.env` is committed (APP_KEY included, SESSION_DRIVER=cookie) — intentional for this demo
- No database add-on required — the app is fully stateless
