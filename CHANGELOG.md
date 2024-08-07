# Changelog

All notable changes to `filament-media-action` will be documented in this file.

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
