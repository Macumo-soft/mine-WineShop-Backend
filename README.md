# -mine-WineShop-Backend


```
docker-compose up -d --build

docker-compose exec php bash

composer install

cp .env.example .env

php artisan key:generate

.envのDBに設定
DB_CONNECTION=pgsql
DB_HOST=database
DB_PORT=5432
DB_DATABASE=mineDB
DB_USERNAME=postgres
DB_PASSWORD=postgres

php artisan migrate

Access FROM Docker
docker exec -it database psql -U postgres laravel_sample

```