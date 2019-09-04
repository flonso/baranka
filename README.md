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

## Development progress
- Teams
  - [x] Create with name, initial score and initial score multiplier
  - [x] Update with manual bonus/penalty on score and score multiplier
  - [x] Retrieve basic team information (name, current score and score multiplier)
  - [ ] Retrieve the global team ranking based on points per event category
- Players
  - [x] Create a player with first name, last name, team and an optional unique code identifier
  - [x] Update a player's level, score or code.
  - [x] Identify a player based on
    - [x] An id
    - [x] A code value
  - [x] Store additional player info
  - [ ] Retrieve the global player ranking
- Game phases
  - [x] Start a new game phase, possibility to give a custom phase number (to compute items' based on it)
  - [x] Stop a game phase
- Items
  - [x] Create an item with name, amount of points gained for discovery, amounts of points gained with the related sidequest, starting phase for its discovery, score multiplier increase value and discovery status.
  - [x] Update an item's found status
    - [x] Distribute discovery points based on game phase and number of players to register it.
    - [x] Discovery points reduce by 100 for each two game phases it is possible to discover the item in
    - [x] Distribute adventure points among player validating it
- Events
  - [ ] Save an event for each gain/loss of points as well as who it benefits to
  - [ ] Track which user of the system has performed an action (optional)
  - [ ] Compute rankings per event category
- [ ] Custom value settings
  - [ ] Configure value used for computations (such as score, item loss of value, ...)



## Development server
Install project dependencies:

`composer install`

Then configure your environment file:

`cp .env.example .env`

And adapt the parameters to your local configuration with your text editor of choice.

Run development server:

`php artisan serve`

**Important**
Do not forget to run migrations before starting developing by executing `php artisan migrate`.

## Important folders

- Controllers are stored in [app/Http/Controllers](./app/Http/Controllers)
- Route definitions are stored in [routes](./routes)
- Model definitions (using Eloquent) are stored in [app/Models](./app/Models)

## Coding standards

The Laravel coding good practices can be found at the following url [https://www.laravelbestpractices.com/](https://www.laravelbestpractices.com/).