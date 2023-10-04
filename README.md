
php artisan migrate
// Migrations divided to patches to rollback without errors 

php artisan db:seed --class=UsersTableSeeder

php artisan db:seed --class=AdminsTableSeeder
