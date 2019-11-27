# zonkoshop

Zonko Shop is a project that simulates a fantasy ecommerce. The idea is to link ecommerce to the future Zonko video game and allow the purchase of objects, weapons, spells etc. to video players directly from the site, without being in game.

This project was designed to pass the practical examination of Web Technologies so it had guidelines and features to be implemented obligatorily.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

**For Ubuntu:**

- LAMP
- Git
- Zip
- PHP > 7.2
- Composer ([Composer Documentation](https://getcomposer.org/doc/03-cli.md))

  `sudo apt-get install composer`
- Laravel Framework 5.8 --> [Laravel installation guide](https://laravel.com/docs/5.5/installation)

### Installing

After `git clone`, go to the terminal in the **repository directory** and run these commands:
- `composer install` to add missing files, except for configuration files
- `cp .env.example .env` to generate new .env file. 
- Open .env file and for `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, enter your credentials to access your database.
- `php artisan migrate` to update the database structure. [E-R Diagram](E-R_Diagram.png)
- `php artisan key:generate` to generate application key
- ``
## Running

Open the terminal in the **repository directory**, run `php artisan serve` and open the link to the localhost.

## Built With

* [Laravel](https://laravel.com/docs/5.8) - The web framework used

## Authors

* **Giulia Vantaggiato** [Giulia Vantaggiato](https://github.com/Celian87)
* **Davide Civolani**
* **Dalila Damiano**

## License

This project is licensed under the MIT License - see the [LICENSE.md](./LICENSE) file for details
