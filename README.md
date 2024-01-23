First Laravel App

# to get start type:
composer create-project laravel/laravel laravelapp

# to run
php artisan serve

# Create tables
php artisan migrate

# Make class controller
php artisan make:controller UserController

# make migration table
php artisan make:migration create_posts_table
# and to migrate
php artisan migrate

# create model
php artisan make:model Post
