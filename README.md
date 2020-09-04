# Lloyd Bank

To start working with this app, open your terminal and clone it into the directory of your choosing. Example: `git clone git@github.com:Lloydinator/lloydbank.git`.

After you've don't that, cd into the directory (`cd \home\www\lloydbank`). The folder labeled 'api' is your backend, while the folder labeled 'web' is your frontend. 

If you want to quickly try this app, you can skip the 'backend' instructions below.

## Backend

To start working with this, you will need to run `composer install`. Once all files are installed, run `cp .env.example .env`. This will create a .env file.

Run `php artisan key:generate` to populate APP_KEY in your .env file. Once the key is generated, add the name of your database and any other particulars for your database. Afterwards, run `touch database/test.sqlite` to create the testing database.

To get your database ready, run `php artisan migrate` and after that run `php artisan migrate --env=testing`. To populate the tables, run `php artisan db:seed` and `php artisan db:seed --env=testing`.
**PLEASE NOTE:** This will create 30 accounts and 60 transactions.

Once you've done that, test your database and configurations by running `php artisan test`. If everything runs smoothly, you can then use Postman to test out your API. Go to routes/api.php to see the available routes to play with. Don't forget to run `php artisan serve` first. 


## Frontend

If you did not create a backend, all you'll have to do is cd into the 'web' folder and run `npm install`. Once everything is installed, go to `pages/accounts/_id.vue`. Whenever you see a link, just replace `http://localhost:8000` with `https://fast-shore-29582.herokuapp.com`. After that, start up the app by running `npm run dev`! 
**PLEASE NOTE:** You may have to disable CORS in your browser to post new transactions. Also initial requests may take a while if the API is 'sleeping'.

If you did create a backend, make sure the API is up and running and follow the steps above. However, this time you won't be replacing `http://localhost:8000`. Enjoy!
