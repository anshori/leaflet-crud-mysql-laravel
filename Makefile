setup:
	composer install
	php artisan key:generate
	npm install
	npm run build
	php artisan migrate

dev:
	php artisan serve

migrate:
	php artisan migrate

migrate-fresh:
	php artisan migrate:fresh --seed

migrate-refresh:
	php artisan migrate:refresh --seed

rollback:
	php artisan migrate:rollback