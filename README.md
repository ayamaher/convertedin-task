
<h2>Migrations</h2>
<p>run the following command to migrate tables to db </p>
<p>php artisan migrate</p>
<b>Rollback mechanism to be considered --> Migrations divided into patches for smooth rollback</b><br>

<h2>Seeders</h2>
<p>run the following 2 command to seed data for both user and admin tables</p>

<p>php artisan db:seed --class=UsersTableSeeder</p>
<p>php artisan db:seed --class=AdminsTableSeeder</p>

<h2>Enable Queue for UpdateStatisticsJob</h2>
<p>run the following command to enable default queue worker </p>
<p>php artisan queue:work</p>

