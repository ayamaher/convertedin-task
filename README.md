
<h3>Migrations</h3>
<p>run the following command to migrate tables to db</p>
<p>php artisan migrate</p>
<b>Rollback mechanism to be considered --> Migrations divided into patches for smooth rollback</b><br>

<h3>Seeders</h3>
<p>run the following 2 commands to seed data for both user and admin tables</p>

<p>php artisan db:seed --class=UsersTableSeeder</p>
<p>php artisan db:seed --class=AdminsTableSeeder</p>

<h3>Enable Queue for UpdateStatisticsJob</h3>
<p>run the following command to enable default queue worker</p>
<p>php artisan queue:work</p>

<h3>Run Project</h3>
<p>php artisan serve</p>

<h3>migrate Testing DB</h3>
<p>php artisan migrate --database=convertedin_db_testing</p>

<h3>Execute All tests</h3>
<p>php artisan test</p>

<h3>Or</h3>
<p>./vendor/bin/phpunit tests/Feature</p>

