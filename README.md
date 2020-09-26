<p align="center"><img src="https://www.ubot41.ch/img/UbotLogo.svg" width="120"></p>

<p align="center">
<a href="https://www.ubot41.ch"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About UBOT41 Cockpit

UBOT41 Cockpit is our scratch point for fresh admin panel.
We have users, groups and permissions management, multi language interface (fresh install provide English and Italian) and some modules.

## Based on

- **[Laravel](https://laravel.com)**: PHP framework
- **[Bootstrap](https://getbootstrap.com/)**: CSS/JS framework (minimum version 4.1)

### Add-on libraries and dependencies

- **[jQuery](https://jquery.com)**: main JS library
- **[Laravel Collective](https://laravelcollective.com)**: Form & HTML library **(required)**
- **[Spatie Permissions](https://docs.spatie.be/laravel-permission/v3/introduction/)**: Role and permissions library **(required)**
- **[Google Material Icons](https://google.github.io/material-design-icons/)**: Icons **(required)**
- **[Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)**: debug bar (only for dev environment)
- **[Axiom](https://github.com/mattkingshott/axiom)**: additional validation rules
- **[Laravel Socialite](https://laravel.com/docs/7.x/socialite)**: additional auth options

## Installation
1. Clone or download this repo
2. Run `composer update` to update all project dependencies
3. Rename `.env.example` file to `.env`
4. Update `.env` file with your personal data
5. Run `php artisan key:generate` to generate a new `APP_KEY` for your app 
6. We use database session. Please run: `php artisan migrate` before import our dummy data
7. Update `/config/cockpit.php` and `/config/app.php` files with your personal data
8. Update `/config/services.php` file with your Facebook API data if you need Facebook auth via Laravel Socialite


### Installation notes
**dummy data**: our dummy data have only 1 admin user with first permissions for user, roles and permissions management: login with `dummy@dummy.com` as username and `dummydummy` as password for the first time

We have add db seeders with all dummy data. After database migration, run `php artisan db:seed` to populate the database. Into `/mysql` you can find our mysql dump if you don't like seeders.

## Contributing

Thank you for considering contributing to the UBOT41 Cockpit.


## License

The UBOT41 Cockpit code is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
