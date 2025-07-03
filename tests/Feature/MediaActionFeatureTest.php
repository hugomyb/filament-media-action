<?php

namespace Hugomyb\FilamentMediaAction\Tests\Feature;

use Filament\Actions\Action;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;
use Hugomyb\FilamentMediaAction\Tests\Support\TestModel;
use Hugomyb\FilamentMediaAction\Tests\Support\TestMediaAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

it('can be used as a standalone action', function () {
    $action = MediaAction::make('view-media')
        ->label('View Media')
        ->media('https://example.com/video.mp4');

    expect($action)->toBeInstanceOf(Action::class);
    expect($action->getLabel())->toBe('View Media');
});

it('can detect youtube media type', function () {
    $testAction = new TestMediaAction('test');

    expect($testAction->getMediaType('https://www.youtube.com/watch?v=dQw4w9WgXcQ'))->toBe('youtube');
    expect($testAction->getMediaType('https://youtu.be/dQw4w9WgXcQ'))->toBe('youtube');
});

it('can detect video media type', function () {
    $testAction = new TestMediaAction('test');

    expect($testAction->getMediaType('https://example.com/video.mp4'))->toBe('video');
    expect($testAction->getMediaType('https://example.com/video.avi'))->toBe('video');
    expect($testAction->getMediaType('https://example.com/video.mov'))->toBe('video');
    expect($testAction->getMediaType('https://example.com/video.webm'))->toBe('video');
});

it('can detect audio media type', function () {
    $testAction = new TestMediaAction('test');

    expect($testAction->getMediaType('https://example.com/audio.mp3'))->toBe('audio');
    expect($testAction->getMediaType('https://example.com/audio.wav'))->toBe('audio');
    expect($testAction->getMediaType('https://example.com/audio.ogg'))->toBe('audio');
    expect($testAction->getMediaType('https://example.com/audio.aac'))->toBe('audio');
});

it('can detect image media type', function () {
    $testAction = new TestMediaAction('test');

    expect($testAction->getMediaType('https://example.com/image.jpg'))->toBe('image');
    expect($testAction->getMediaType('https://example.com/image.jpeg'))->toBe('image');
    expect($testAction->getMediaType('https://example.com/image.png'))->toBe('image');
    expect($testAction->getMediaType('https://example.com/image.gif'))->toBe('image');
    expect($testAction->getMediaType('https://example.com/image.bmp'))->toBe('image');
    expect($testAction->getMediaType('https://example.com/image.svg'))->toBe('image');
    expect($testAction->getMediaType('https://example.com/image.webp'))->toBe('image');
});

it('can detect pdf media type', function () {
    $testAction = new TestMediaAction('test');

    expect($testAction->getMediaType('https://example.com/document.pdf'))->toBe('pdf');
});

it('can handle urls with query parameters', function () {
    $testAction = new TestMediaAction('test');

    expect($testAction->getMediaType('https://example.com/video.mp4?token=123&param=value'))->toBe('video');
});

it('returns unknown for unsupported media types', function () {
    $testAction = new TestMediaAction('test');

    expect($testAction->getMediaType('https://example.com/file.xyz'))->toBe('unknown');
    expect($testAction->getMediaType('https://example.com/path/'))->toBe('unknown');
});
