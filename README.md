# opendor.me

## Docker / Laradock

```bash
cp .env.laradock .env
# configure Laravel ENV
cd laradock-opendor
docker-compose up -d nginx postgres redis
docker-compose exec workspace bash
composer update
npm install
npm run dev
php artisan key:generate
php artisan migrate
```
