# Laravel Encore

Package made for those who understand the power of [symfony/webpack-encore](https://github.com/symfony/webpack-encore)

## Installation

### Frontend

You can read more about webpack encore
on [official symfony's docs page](https://symfony.com/doc/current/frontend.html#webpack-encore).

For the Laravel project you'll only need next setup:

1. Install the node package\
   `yarn add @symfony/webpack-encore --dev`

2. Create basic configuration file `webpack.config.js`

```javascript
const Encore = require('@symfony/webpack-encore');

/* [configuration and entrypoints, see docs] */

module.exports = Encore.getWebpackConfig();
```

3. Add shortcuts to the `package.json` scripts section

```json
{
    "dev-server": "encore dev-server",
    "dev": "encore dev",
    "build": "encore production",
    "deploy": "encore production"
}
```

### Backend

1. Install the PHP library on your Laravel project\
   `composer require ntpages/laravel-encore`

2. Copy the config files\
   `php artisan vendor:publish`

3. Add the provider in `config/app.php` providers section

```php
Ntpages\LaravelEncore\EncoreServiceProvider::class
```

You're ready to go!

## Usage

It's as simple as just using the helpers from the package!\

For javascripts:

```php
<?=encore_script_tags('app')?>
```

For stylesheets:

```php
<?=encore_link_tags('app')?>
```

> You can stop worrying about where you include the entry files the package manages duplications for you
> and prints tags only once per page render.

### Advanced config

TBD
