# Baranka Live-action role playing game software
Software for managing role play game Baranka 2019. Based on https://github.com/LucieSteiner/tildawn


## Requirements
This code is built using the [Laravel framework](https://laravel.com).

PHP Requirements:
- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension


## Development server
Install project dependencies:

`composer install`

Then configure your environment file:

`cp .env.example .env`

And adapt the parameters to your local configuration with your text editor of choice.

Run development server:

`php artisan serve`

## Important folders

- Controllers are stored in [app/Http/Controllers](./app/Http/Controllers)
- Route definitions are stored in [routes](./routes)
- Model definitions (using Eloquent) are stored in []