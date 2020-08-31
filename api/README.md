# The Backend of the app

First, run `composer install`. Once all files are installed, run `cp .env.example .env` and then run `php artisan key:generate`. This will generate a key for your app. 

Once the key is generated, add the name of your database and any other particulars for your database. Once you've done that, run `touch database/test.sqlite` to create the testing database.

Once that's done, run `php artisan migrate` and after that run `php artisan migrate --env=testing` to get your databases up. Afterwards, run `php artisan db:seed` and `php artisan db:seed --env=testing` to populate the tables.
**PLEASE NOTE:** This will create 30 accounts and 60 transactions.

Once you've done that, test your database and configurations by running `php artisan test`. If everything runs smoothly, you can then use Postman to test out your API. Don't forget to run `php artisan serve` first. 