Setup Instructions<br>
1. Clone the Repository<br>
First, clone the repository to your local machine by running the following command:<br>

git clone https://github.com/yourusername/your-repository-name.git.<br><br>
Navigate to the project directory:<br>

cd your-repository-name<br><br><br>
2. Install Dependencies<br>
Make sure you have Composer installed. If not, you can download it from here.<br>

Once Composer is installed, run the following command to install all the necessary dependencies:<br>

composer install<br><br><br>
3. Create a .env File<br>
Copy the .env.example file to create your .env file:<br>

cp .env.example .env<br><br><br>
4. Generate the Application Key<br>
Run the following command to generate the application key:<br>

php artisan key:generate<br>

This will set a random key in your .env file for encryption.<br><br><br>

5.  Set Up the Database<br>
Make sure you have a SQLite or MySQL database set up.<br>

For SQLite:<br>
Ensure that the database file exists (or will be created). In .env, configure the DB_CONNECTION to sqlite:<br>

DB_CONNECTION=sqlite<br>
DB_DATABASE=/path_to_your_database/database.sqlite<br><br>
If you don’t have a database file yet, you can create one:<br>


touch database/database.sqlite<br>
For MySQL:<br>
If you Are using MySQL, configure .env as follows:<br>

DB_CONNECTION=mysql<br>
DB_HOST=host<br>
DB_PORT=port<br>
DB_DATABASE=your_database_name<br>
DB_USERNAME=your_database_user<br>
DB_PASSWORD=your_database_password<br><br><br>

6.  Run Migrations and Seeders<br>
Now, run the database migrations to create the required tables:<br><br>

php artisan migrate<br><br>

If you have seeders for testing, you can run them to populate the database with some initial data:<br>


php artisan db:seed<br><br><br>

7. Install Laravel Passport for Authentication<br>
Since the app uses Laravel Passport for API authentication, you need to install the Passport package and set it up.<br><br>

Run the following command to install Passport:<br><br>

composer require laravel/passport<br>
After installation, run the following commands to configure Passport:<br><br>

php artisan passport:install<br>
This will generate the encryption keys needed for Passport.<br><br>

Next, in your AuthServiceProvider (located at app/Providers/AuthServiceProvider.php), add the following line to the boot() method:<br><br>

use Laravel\Passport\Passport;<br><br>

Finally, in your .env file, make sure the APP_URL is set correctly:<br>
<br>
APP_URL=http://yourappurl(localhost)<br><br><br>
8. Serve the Application<br>
You can now run the application locally by using Laravel builtin server:<br>
<br>
php artisan serve<br>
This will start the server, and your app will be accessible at:<br>
<br>
http://localhost:port<br><br><br>
9. Testing the API<br>
Now, you can use Postman or any API client to test the various endpoints. Remember to authenticate using Bearer tokens after registering or logging in.<br>
<br>
10. Additional Configuration (Optional)<br>
Caching: You may need to clear the applications cache during development. You can do so with the following command:<br>
<br>
php artisan cache:clear<br>
Queue (Optional): If your app uses queues, you may need to set up your queue configuration in the .env file and configure it accordingly.<br>
<br><br><br>
Troubleshooting<br>
Missing Dependencies: If you encounter any errors while running composer install, ensure that your PHP version meets the Laravel version requirements.<br>
<br>
Database Errors: Ensure your database is correctly configured in .env and the migrations have been run successfully.<br>
<br>
Authentication Issues: Ensure Laravel Passport has been set up correctly and the necessary routes have been registered<br>
