# Deploy na Vercel

## 1. Připojit GitHub repo k Vercelu

1. https://vercel.com/new
2. Import Git Repository → vyber `simplemat-cz/cirkevkolin`
3. Framework Preset: **Other** (nech ho tak, `vercel.json` to řeší)
4. Root Directory: `./` (default)
5. **Neklikej na Deploy** ještě — nejdřív nastav env vars (dole)

## 2. Databáze (externí)

Vercel nemá persistent MySQL/SQLite. Nejjednodušší zdarma:

### Neon Postgres (doporučeno, 3GB zdarma)
1. https://neon.tech → Create project
2. Zkopíruj connection string
3. V Laravel .env použij:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=ep-xyz.eu-central-1.aws.neon.tech
   DB_PORT=5432
   DB_DATABASE=neondb
   DB_USERNAME=<uživatel>
   DB_PASSWORD=<heslo>
   DB_SSLMODE=require
   ```

### Vercel Postgres
Přímo v Vercel dashboardu → Storage → Create → Postgres

## 3. Env vars v Vercelu

Settings → Environment Variables (všechna prostředí):

| Název | Hodnota |
|---|---|
| `APP_NAME` | `církev kolín` |
| `APP_ENV` | `production` |
| `APP_KEY` | vygeneruj lokálně: `php artisan key:generate --show` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://<tvoje-app>.vercel.app` |
| `APP_LOCALE` | `cs` |
| `APP_TIMEZONE` | `Europe/Prague` |
| `DB_CONNECTION` | `pgsql` (nebo `mysql`) |
| `DB_HOST` | z Neon/PlanetScale |
| `DB_PORT` | `5432` (Postgres) |
| `DB_DATABASE` | název databáze |
| `DB_USERNAME` | uživatel |
| `DB_PASSWORD` | heslo |
| `DB_SSLMODE` | `require` (pro Neon) |
| `SESSION_DRIVER` | `cookie` |
| `CACHE_DRIVER` | `array` |
| `QUEUE_CONNECTION` | `sync` |
| `LOG_CHANNEL` | `stderr` |
| `MAIL_MAILER` | `log` (nebo nastavit SMTP) |
| `MAIL_FROM_ADDRESS` | `kolin@apostolskacirkev.cz` |
| `MAIL_ADMIN_ADDRESS` | `michal@simplemat.cz` |
| `SCOUT_DRIVER` | `null` |
| `YOUTUBE_CHANNEL_ID` | `UCnsKOpdlWx4wS0mos_PXfDg` |

## 4. První deploy

1. Klikni **Deploy** v Vercelu
2. Počkej na build (~2-3 min)
3. Po buildu otevři **Vercel Functions → Logs** ať vidíš případné errory

## 5. Databáze migrace + seed

Po prvním deployi musíš manuálně spustit migrace. Tři možnosti:

### A) Lokálně proti produkční DB (jednorázově)
```bash
# V .env si dočasně nastav produkční DB_HOST/DB_PASSWORD
php artisan migrate --force
php artisan db:seed --force
```

### B) Přes Vercel CLI
```bash
vercel env pull .env.vercel
cp .env.vercel .env
php artisan migrate --force
php artisan db:seed --force
```

### C) Vercel Function (nedoporučuju — 10s timeout)

## 6. Známá omezení na Vercelu

- **Soubory**: `/tmp` je jediný zapisovatelný adresář → file uploads nefungují. Na Filament admin potřebuješ S3/R2.
- **Queue**: Jen `sync` (emaily se posílají v requestu, pomalé). Na queue workery jdi jinam (Railway).
- **Schedule/Cron**: Vercel Cron Jobs je placený feature. Pro `youtube:sync` použij GitHub Actions cron → `vercel deploy webhook`.
- **10s / 30s timeout**: Filament admin s velkým datasetem může padnout.

## 7. Pro skutečnou produkci

Vercel je fajn pro **marketing/showcase**, ale pro plnohodnotný web s admin + file uploads + scheduler použij:
- **Railway** — Laravel + MySQL + workers out-of-the-box, $5/měsíc
- **Fly.io** — Docker-based, skvělé pro Laravel
- **Forge + DigitalOcean droplet** — $6/měsíc, industry standard pro Laravel
