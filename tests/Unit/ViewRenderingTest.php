<?php

use Hugomyb\FilamentMediaAction\Actions\MediaAction;

it('has a valid media modal content view file', function () {
    $viewPath = __DIR__ . '/../../resources/views/actions/media-modal-content.blade.php';

    expect(file_exists($viewPath))->toBeTrue();

    $content = file_get_contents($viewPath);

    expect($content)->toContain('<div class="w-full flex flex-col justify-center items-center h-full"');
    expect($content)->toContain('@if ($mediaType === \'youtube\')');
    expect($content)->toContain('@elseif ($mediaType === \'audio\')');
    expect($content)->toContain('@elseif ($mediaType === \'video\')');
    expect($content)->toContain('@elseif ($mediaType === \'image\')');
    expect($content)->toContain('@elseif ($mediaType === \'pdf\')');
});

it('can set media url', function () {
    $url = 'https://example.com/video.mp4';
    $action = MediaAction::make('test')->media($url);

    $reflection = new ReflectionProperty($action, 'media');

    expect($reflection->getValue($action))->toBe($url);
});

it('can set autoplay option', function () {
    $action = MediaAction::make('test')->autoplay();

    $reflection = new ReflectionProperty($action, 'hasAutoplay');

    expect($reflection->getValue($action))->toBeTrue();

    $action->autoplay(false);

    expect($reflection->getValue($action))->toBeFalse();
});

it('can set preload option', function () {
    $action = MediaAction::make('test')->preload(false);

    $reflection = new ReflectionProperty($action, 'preloadAuto');

    expect($reflection->getValue($action))->toBeFalse();

    $action->preload(true);

    expect($reflection->getValue($action))->toBeTrue();
});

it('can see media control methods', function () {
    $action = MediaAction::make('test');

    expect(method_exists($action, 'disableDownload'))->toBeTrue();
    expect(method_exists($action, 'disableFullscreen'))->toBeTrue();
    expect(method_exists($action, 'disableRemotePlayback'))->toBeTrue();
});
