<?php

use Hugomyb\FilamentMediaAction\Tests\Support\TestMediaAction;

it('can detect YouTube URLs', function () {
    $action = new TestMediaAction('test');

    expect($action->getMediaType('https://www.youtube.com/watch?v=dQw4w9WgXcQ'))->toBe('youtube');
    expect($action->getMediaType('https://youtu.be/dQw4w9WgXcQ'))->toBe('youtube');
});

it('can detect video file extensions', function () {
    $action = new TestMediaAction('test');
    $videoExtensions = ['mp4', 'avi', 'mov', 'webm'];

    foreach ($videoExtensions as $extension) {
        expect($action->getMediaType("https://example.com/video.$extension"))->toBe('video');
    }
});

it('can detect audio file extensions', function () {
    $action = new TestMediaAction('test');
    $audioExtensions = ['mp3', 'wav', 'ogg', 'aac'];

    foreach ($audioExtensions as $extension) {
        expect($action->getMediaType("https://example.com/audio.$extension"))->toBe('audio');
    }
});

it('can detect image file extensions', function () {
    $action = new TestMediaAction('test');
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

    foreach ($imageExtensions as $extension) {
        expect($action->getMediaType("https://example.com/image.$extension"))->toBe('image');
    }
});

it('can detect PDF file extension', function () {
    $action = new TestMediaAction('test');

    expect($action->getMediaType('https://example.com/document.pdf'))->toBe('pdf');
});

it('can handle URLs with query parameters', function () {
    $action = new TestMediaAction('test');

    expect($action->getMediaType('https://example.com/video.mp4?token=123&param=value'))->toBe('video');
});

it('returns unknown for URLs with trailing slashes', function () {
    $action = new TestMediaAction('test');

    expect($action->getMediaType('https://example.com/path/'))->toBe('unknown');
});

it('returns unknown for unsupported file extensions', function () {
    $action = new TestMediaAction('test');

    expect($action->getMediaType('https://example.com/file.xyz'))->toBe('unknown');
});
