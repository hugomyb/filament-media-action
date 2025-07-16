# ▶️ Filament Media Action

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hugomyb/filament-media-action.svg?style=flat-square)](https://packagist.org/packages/hugomyb/filament-media-action)
[![Total Downloads](https://img.shields.io/packagist/dt/hugomyb/filament-media-action.svg?style=flat-square)](https://packagist.org/packages/hugomyb/filament-media-action)



Automatically display your media (video, audio, pdf, image, ...) with an action in Filament.
The package automatically detects the media extension to display the correct player.

## Examples

![example1](https://raw.githubusercontent.com/hugomyb/filament-media-action/main/docs/example1.png)
![example2](https://raw.githubusercontent.com/hugomyb/filament-media-action/main/docs/example2.png)
![example3](https://raw.githubusercontent.com/hugomyb/filament-media-action/main/docs/example3.png)
![example4](https://raw.githubusercontent.com/hugomyb/filament-media-action/main/docs/example4.png)
![example5](https://raw.githubusercontent.com/hugomyb/filament-media-action/main/docs/example5.png)
![example6](https://raw.githubusercontent.com/hugomyb/filament-media-action/main/docs/example6.png)
![example7](https://raw.githubusercontent.com/hugomyb/filament-media-action/main/docs/example7.png)

## Installation

You can install the package via composer:

```bash
composer require hugomyb/filament-media-action
```

Optionally, you can publish the view using

```bash
php artisan vendor:publish --tag="filament-media-action-views"
```

Optionally, you can publish the translations using

```bash
php artisan vendor:publish --tag="filament-media-action-translations"
```

## Usage

### Basic Usage

Like a classic Filament Action, you can use MediaAction anywhere (Forms, Tables, Infolists, Suffix and prefix, ...).

Simply provide the url of your media in the `->media()` method. The package will then automatically detect your media extension for display.
```php
MediaAction::make('tutorial')
    ->iconButton()
    ->icon('heroicon-o-video-camera')
    ->media('https://www.youtube.com/watch?v=rN9XI9KCz0c&list=PL6tf8fRbavl3jfL67gVOE9rF0jG5bNTMi')
```

### Available options

#### Autoplay

You can enable autoplay for video and audio by using the `->autoplay()` method.

```php
MediaAction::make('media-url')
    ->media(fn($record) => $record->url)
    ->autoplay()
```

You can also pass a closure in the method and access `$record` and `$mediaType` :

```php
MediaAction::make('media-url')
    ->media(fn($record) => $record->url)
    ->autoplay(fn($record, $mediaType) => $mediaType === 'video')
```

`$mediatype` can return "youtube", "audio", "video", "image" or "pdf".

#### Force Media Type

If the automatic media type detection fails (common with local development URLs or files without extensions), you can force the media type:

```php
MediaAction::make('video')
    ->media('https://myapp.test/video.MOV')
    ->mediaType('video') // Force video type
```

Available media types: `'video'`, `'audio'`, `'image'`, `'pdf'`, `'youtube'`.

#### Preload

To control the preload behavior, use the ->preload() method. By default, it is set to true, which means the media will preload automatically. You can set it to false to disable preloading (this is helpful to avoid "Autoplay failed or was blocked" errors in some browsers).

```php
MediaAction::make('media-url')
    ->media(fn($record) => $record->url)
    ->autoplay()
    ->preload(false)
```

#### Control list

You can control the media player's interface by using the control list options. These options allow you to disable certain features of the HTML5 video and audio players.

> **Note:** Control list options only work in Chromium-based browsers (Chrome, Edge, etc.) and have no effect in Firefox, Safari, or other browsers.

You can use the following convenience methods:

```php
MediaAction::make('media-url')
    ->media(fn($record) => $record->url)
    ->disableDownload() // Prevents the user from downloading the media
    ->disableFullscreen() // Prevents the user from viewing the video in fullscreen
    ->disableRemotePlayback() // Prevents the user from using remote playback (e.g., Chromecast)
```

Each of these methods can accept a boolean or a closure:

```php
MediaAction::make('media-url')
    ->media(fn($record) => $record->url)
    ->disableDownload(fn($record) => $record->is_protected)
```

You can also set the control list directly using the `controlsList` method:

```php
MediaAction::make('media-url')
    ->media(fn($record) => $record->url)
    ->controlsList(['nodownload', 'nofullscreen', 'noremoteplayback'])
```

Or with a closure:

```php
MediaAction::make('media-url')
    ->media(fn($record) => $record->url)
    ->controlsList(fn($record) => $record->is_protected ? ['nodownload'] : [])
```

#### Other options

You can customize the modal as you wish in the same way as a classic action (see https://filamentphp.com/docs/3.x/actions/modals).

If there is an existing record, you can access it by passing a closure to `->media()` method.

Accessible parameters: `$livewire`, `$data`, `$model`, `$record`, `$arguments`.

Example :
```php
MediaAction::make('media-url')
    ->modalHeading(fn($record) => $record->name)
    ->modalFooterActionsAlignment(Alignment::Center)
    ->media(fn($record) => $record->url)
    ->extraModalFooterActions([
        MediaAction::make('media-video2')
            ->media('https://www.youtube.com/watch?v=9GBXqWKzfIM&list=PL6tf8fRbavl3jfL67gVOE9rF0jG5bNTMi&index=3')
            ->extraModalFooterActions([
                MediaAction::make('media-video3')
                    ->media('https://www.youtube.com/watch?v=Bvb_vqzhRQs&list=PL6tf8fRbavl3jfL67gVOE9rF0jG5bNTMi&index=5')
            ]),

        Tables\Actions\Action::make('open-url')
            ->label('Open in browser')
            ->url(fn($record) => $record->url)
            ->openUrlInNewTab()
            ->icon('heroicon-o-globe-alt')
    ])
```

As shown in the example above, you can chain MediaActions together with `->extraModalFooterActions()` method.

## Customizing the modal view

You can customize the modal view by publishing the view using :

```bash
php artisan vendor:publish --tag="filament-media-action-views"
```

Then, in the view, you can access : 
- `$mediaType`: To retrieve the type of your media, which can be “youtube”, “audio”, “video”, “image” or “pdf”.
- `$media` : To retrieve the url of your media


## Supported media extensions

| Type      | Extensions           |
|-----------|----------------------|
| Video     | mp4, avi, mov, webm, mkv, flv, wmv, 3gp, ogv, m4v  |
| Audio     | mp3, wav, ogg, aac, flac, m4a, wma   |
| Documents | pdf                  |
| Image     | jpg, jpeg, png, gif, bmp, svg, webp, tiff, ico |


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
