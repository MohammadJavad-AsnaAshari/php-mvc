# Online Video Game Shop Website

This is a PHP MVC project for a database course that implements an online video game shop website. The website includes features such as a home page, shop page, popular products, categories, product comments, about us, contact us, cart, and an admin panel with various permission levels.

# Getting Started

To get started with the project, follow these steps:

1. Clone the repository from GitHub:
```
git clone https://github.com/MohammadJavad-AsnaAshari/php-mvc
```

2. Navigate to the project directory:
```
cd php-mvc
```

3. Create a new database for the project.
```
sudo mysql -u [user name] -p
```

4. Install php packages:
```
composer install
```

5. Copy the example environment file and modify the configuration:
```
cp .env.example .env
```

6. Then, open the .env file and update the database configuration with your own credentials.
```
vim .env
```

7. Run the database migrations:
```
php database/migration.php
```

8. Start the PHP development server:
```
php -S localhost:8080 -t public
```

9. Create an admin user by visiting the following URL in your browser:
```
http://localhost:8080/admin/create
```

10. Log in to the admin panel using the following credentials:
```
Email: admin@gmail.com
Password: password
```

`Note: After creating an admin user, make sure to remove the /admin/create route from route/web.php and change the default password.`

# Additional Features
In addition to the standard features, this project also utilizes `Admin Panel`, `CRUD`(Create, Read, Update, Delete) `Export Data` from database as `PDF`, `Excel` and `Word`, Transactions `log` and database tools like `transactions`, `sored procedure`, `function`, `view`, `triggers`, and `cursors`.

# Contributing
If you'd like to contribute to this project, please follow the standard GitHub workflow:

* Fork the repository.
* Create a new branch for your feature or bug fix.
* Make your changes and commit them with clear and concise messages.
* Push your changes to your forked repository.
* Submit a pull request to the main repository.
