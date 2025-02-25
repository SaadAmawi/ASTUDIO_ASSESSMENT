Setup Instructions
1. Clone the Repository
First, clone the repository to your local machine by running the following command:
\n
\n
git clone https://github.com/yourusername/your-repository-name.git \n\n
Navigate to the project directory:

cd your-repository-name
2. Install Dependencies
Make sure you have Composer installed. If not, you can download it from here.

Once Composer is installed, run the following command to install all the necessary dependencies:

composer install
3. Create a .env File
Copy the .env.example file to create your .env file:

cp .env.example .env
4. Generate the Application Key
Run the following command to generate the application key:

php artisan key:generate

This will set a random key in your .env file for encryption.

5. Set Up the Database
Make sure you have a SQLite or MySQL database set up.

For SQLite:
Ensure that the database file exists (or will be created). In .env, configure the DB_CONNECTION to sqlite:

DB_CONNECTION=sqlite
DB_DATABASE=/path_to_your_database/database.sqlite
If you don’t have a database file yet, you can create one:


touch database/database.sqlite
For MySQL:
If you Are using MySQL, configure .env as follows:

DB_CONNECTION=mysql
DB_HOST=host
DB_PORT=port
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

6. Run Migrations and Seeders
Now, run the database migrations to create the required tables:

php artisan migrate

If you have seeders for testing, you can run them to populate the database with some initial data:


php artisan db:seed

7. Install Laravel Passport for Authentication
Since the app uses Laravel Passport for API authentication, you need to install the Passport package and set it up.

Run the following command to install Passport:

composer require laravel/passport
After installation, run the following commands to configure Passport:

php artisan passport:install
This will generate the encryption keys needed for Passport.

Next, in your AuthServiceProvider (located at app/Providers/AuthServiceProvider.php), add the following line to the boot() method:

use Laravel\Passport\Passport;

public function boot()
{
    $this->registerPolicies();

    Passport::routes();
}
Finally, in your .env file, make sure the APP_URL is set correctly:

APP_URL=http://yourappurl(localhost)
8. Serve the Application
You can now run the application locally by using Laravel builtin server:

php artisan serve
This will start the server, and your app will be accessible at:

http://localhost:port
9. Testing the API
Now, you can use Postman or any API client to test the various endpoints. Remember to authenticate using Bearer tokens after registering or logging in.

10. Additional Configuration (Optional)
Caching: You may need to clear the applications cache during development. You can do so with the following command:

php artisan cache:clear
Queue (Optional): If your app uses queues, you may need to set up your queue configuration in the .env file and configure it accordingly.

Troubleshooting
Missing Dependencies: If you encounter any errors while running composer install, ensure that your PHP version meets the Laravel version requirements.

Database Errors: Ensure your database is correctly configured in .env and the migrations have been run successfully.

Authentication Issues: Ensure Laravel Passport has been set up correctly and the necessary routes have been registered
