<?php

use Filament\Actions\Action;
use Filament\Tables\Actions\Action as TableAction;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;

it('extends Filament Action class', function () {
    expect(MediaAction::class)->toExtend(Action::class);
});

it('uses HasMedia trait', function () {
    $traits = class_uses(MediaAction::class);

    expect($traits)->toHaveKey('Hugomyb\FilamentMediaAction\Concerns\HasMedia');
});

it('has a service provider', function () {
    $providers = config('app.providers', []);

    expect(class_exists('Hugomyb\FilamentMediaAction\FilamentMediaActionServiceProvider'))->toBeTrue();
});

it('has views', function () {
    $viewPath = __DIR__ . '/../../resources/views';

    expect(is_dir($viewPath))->toBeTrue();
    expect(file_exists($viewPath . '/actions/media-modal-content.blade.php'))->toBeTrue();
});

it('has translations', function () {
    $langPath = __DIR__ . '/../../resources/lang';

    expect(is_dir($langPath))->toBeTrue();
});

it('can be used with Filament Tables', function () {
    $action = MediaAction::make('view-media')
        ->label('View Media')
        ->media('https://example.com/video.mp4');

    expect(method_exists($action, 'label'))->toBeTrue();
    expect(method_exists($action, 'icon'))->toBeTrue();
    expect(method_exists($action, 'iconButton'))->toBeTrue();
    expect(method_exists($action, 'modalHeading'))->toBeTrue();
    expect(method_exists($action, 'modalDescription'))->toBeTrue();
    expect(method_exists($action, 'modalWidth'))->toBeTrue();
    expect(method_exists($action, 'extraModalFooterActions'))->toBeTrue();
    expect(method_exists($action, 'media'))->toBeTrue();
    expect(method_exists($action, 'autoplay'))->toBeTrue();
    expect(method_exists($action, 'preload'))->toBeTrue();
    expect(method_exists($action, 'disableDownload'))->toBeTrue();
    expect(method_exists($action, 'disableFullscreen'))->toBeTrue();
    expect(method_exists($action, 'disableRemotePlayback'))->toBeTrue();
});
