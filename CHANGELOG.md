# Changelog

All notable changes to `filament-media-action` will be documented in this file.

## v4.0.0.0 - support Filament V4 - 2025-07-28

### What's Changed

* feat: add support for filament 4.x by @mansoorkhan96 in https://github.com/hugomyb/filament-media-action/pull/23

### New Contributors

* @mansoorkhan96 made their first contribution in https://github.com/hugomyb/filament-media-action/pull/23

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.1.9...v4.0.0.0

## v3.1.1.9 - 2025-07-16

### Enhanced Video Support & Local Development Fixes

#### 🚀 New Features

##### Force Media Type Detection

- New **mediaType()** method to override automatic media type detection
- Perfect for local development URLs and edge cases where automatic detection fails

```php
MediaAction::make('video')
    ->media('https://myapp.test/video.MOV')
    ->mediaType('video') // Force video type


```
#### 🐛 Bug Fixes

##### Fixed Local Video Loading Issues

- Resolved: Videos from local storage URLs showing "Loading..." indefinitely
- Fixed: Case-sensitive file extension detection (.MOV vs .mov)
- Improved: Network timeout handling for local development domains

##### Enhanced Media Type Detection

- Added timeout protection (5 seconds) for HTTP header requests
- Better error handling for inaccessible URLs
- Graceful fallback when header detection fails

#### 📈 Improvements

##### Expanded Format Support

- Video formats: Added support for mkv, flv, wmv, 3gp, ogv, m4v
- Audio formats: Added support for flac, m4a, wma
- Image formats: Added support for tiff, ico

## v3.1.1.8 - 2025-07-03

### What's Changed

* controlsList support by @clnt in https://github.com/hugomyb/filament-media-action/pull/22

### New Contributors

* @clnt made their first contribution in https://github.com/hugomyb/filament-media-action/pull/22

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.1.7...v3.1.1.8

## v3.1.1.7 - 2025-02-11

### 🚀 Release v3.1.1.7 – Dynamic Closure Dependency Resolution

#### ✨ What's New?

##### Automatic resolution of dependencies for `evaluate()`

- No more manual listing of dependencies (`record`, `model`, `arguments`, `data`, `livewire`).
- All closures evaluated with `evaluate()` now automatically receive all available dependencies.
- Improved flexibility and maintainability of the package.

#### 🐛 Fixes & Improvements

- Optimized code to eliminate redundant calls to `resolveDefaultClosureDependencyForEvaluationByName()`.
- Reduced errors caused by missing dependencies in `evaluate()`.

## v3.1.1.6 - 2025-01-15

### What's Changed

* Add italian translation by @masterix21 in https://github.com/hugomyb/filament-media-action/pull/16

### New Contributors

* @masterix21 made their first contribution in https://github.com/hugomyb/filament-media-action/pull/16

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.1.5...v3.1.1.6

## v3.1.1.5 - 2024-12-17

### What's Changed

* Fix header case for some hosts. by @jimmystelzer in https://github.com/hugomyb/filament-media-action/pull/15

### New Contributors

* @jimmystelzer made their first contribution in https://github.com/hugomyb/filament-media-action/pull/15

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.1.4...v3.1.1.5

## v3.1.1.4 - 2024-12-06

### Release: Improved Media Loading Experience

#### Features

- Added consistent loading indicator display for all media types, including YouTube videos, images, and PDFs.
- Introduced a delay mechanism (200ms) to ensure the loading indicator is visible for fast-loading media.

#### Fixes

- Resolved an issue where the loading indicator would not appear for images and iframes.
- Improved initialization logic to handle unsupported or missing media elements without errors.
- Enhanced media handling to better support `<video>`, `<audio>`, `<img>`, and `<iframe>` elements.

#### Notes

This release enhances the user experience by providing a reliable loading indicator for all supported media formats in the Filament Media Viewer package.

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.1.3...v3.1.1.4

## v3.1.1.3 - 2024-12-05

### Release: Media Viewer Fixes and Improvements

#### Features

- Enhanced media type support: Improved handling for YouTube videos, images, PDFs, and other media types in the viewer.
- Added dynamic checks for `<video>` and `<audio>` elements to prevent errors when unsupported methods like `.load()` are called.

#### Fixes

- Resolved Alpine Expression Error: "mediaElement.load is not a function" by ensuring `.load()` is only invoked on compatible media elements.
- Improved stability and loading logic for all media types, including fallback handling for `<img>` and iframes.

#### Notes

This release ensures a smoother user experience and greater compatibility for diverse media formats in the Filament Media Viewer package.

## v3.1.1.2 - 2024-11-10

### What's Changed

* Fix playing video on iPhone by @mokhosh in https://github.com/hugomyb/filament-media-action/pull/13

### New Contributors

* @mokhosh made their first contribution in https://github.com/hugomyb/filament-media-action/pull/13

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.1.1...v3.1.1.2

## v3.1.1.1 - 2024-10-31

### What's Changed

* Fix intermittent autoplay blocking issue by adding preload control option by @waggos-root in https://github.com/hugomyb/filament-media-action/pull/11

### New Contributors

* @waggos-root made their first contribution in https://github.com/hugomyb/filament-media-action/pull/11

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.1.0...v3.1.1.1

## v3.1.1.0 - 2024-10-18

### What's Changed

- Fix audio loading on iOS devices: Resolved an issue where audio files were not loading properly on iPhones, resulting in an infinite spinner. Added additional event listeners (@canplay, @loadeddata, and @play) to improve the loading state handling of audio elements.

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.0.8...v3.1.1.0

## v3.1.0.9 - 2024-10-02

### What's Changed

* Improve youtube url parsing to use youtu.be and youtube.com urls by @claybitner in https://github.com/hugomyb/filament-media-action/pull/9

### New Contributors

* @claybitner made their first contribution in https://github.com/hugomyb/filament-media-action/pull/9

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.0.8...v3.1.0.9

## v3.1.0.8 - 2024-09-25

### Feature: Media Autoplay in Modal

#### Description:

Implemented a media autoplay feature that automatically plays embedded audio, video, and YouTube media when the modal is opened. This feature adds the `->autoplay()` method.

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.0.7...v3.1.0.8

## v3.1.0.7 - 2024-08-21

### Fix

Add default value to $mime to prevent "MediaAction::$mime must not be accessed before initialization"

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.0.6...main

## v3.1.0.6 - 2024-08-13

### Fix

Enhanced the mime type detection of complex media url

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.0.5...main

## v3.1.0.5 - 2024-08-07

Fixed "Unsupported media type" if the media url has no extension, checking the `Content-Type` header

**Full Changelog**: https://github.com/hugomyb/filament-media-action/compare/v3.1.0.4...main

## Fix - 2024-08-06

Fixed error message "Unsupported media", if the media url contains query parameters

## v3.1.0.3 - 2024-07-31

### Fix :

- Remove google viewer for PDFs

## v3.1.0.2 - 2024-07-31

### Fix :

- Use google viewer to preview PDFs

## v3.1.0.1 - 2024-07-31

Fixes :

- Better use of loading state, to check that the media is not already loaded
- Using an embed tag instead of an iframe to display pdf files

## v3.1.0.0 - 2024-07-30

### Release v3.1.0.0

#### What's New

- First stable version of the plugin for FilamentPHP.
- Add MediaAction to display images, videos, audio, pdf, ... quickly and easily

#### Features

- Add MediaAction for Tables, Forms, Infolists, ...
- Supports Laravel 11 and FilamentPHP V3.

## 1.0.0 - 202X-XX-XX

- initial release
