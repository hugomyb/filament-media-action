# Changelog

All notable changes to `filament-media-action` will be documented in this file.

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
