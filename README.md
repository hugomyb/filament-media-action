# Automatically display your media (video, audio, document, image, ...) with an action

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hugomyb/filament-media-action.svg?style=flat-square)](https://packagist.org/packages/hugomyb/filament-media-action)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hugomyb/filament-media-action/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hugomyb/filament-media-action/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hugomyb/filament-media-action/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hugomyb/filament-media-action/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hugomyb/filament-media-action.svg?style=flat-square)](https://packagist.org/packages/hugomyb/filament-media-action)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require hugomyb/filament-media-action
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-media-action-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-media-action-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-media-action-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentMediaAction = new Hugomyb\FilamentMediaAction();
echo $filamentMediaAction->echoPhrase('Hello, Hugomyb!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mayonobe Hugo](https://github.com/hugomyb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
