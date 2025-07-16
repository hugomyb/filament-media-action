<?php

namespace Hugomyb\FilamentMediaAction\Tests\Feature;

use Hugomyb\FilamentMediaAction\Actions\MediaAction;

it('detects video type from MOV extension (case insensitive)', function () {
    $action = MediaAction::make('test')
        ->media('https://example.com/video.MOV');
    
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('getMediaType');
    $method->setAccessible(true);
    
    $result = $method->invoke($action, 'https://example.com/video.MOV');
    
    expect($result)->toBe('video');
});

it('detects video type from mov extension (lowercase)', function () {
    $action = MediaAction::make('test')
        ->media('https://example.com/video.mov');
    
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('getMediaType');
    $method->setAccessible(true);
    
    $result = $method->invoke($action, 'https://example.com/video.mov');
    
    expect($result)->toBe('video');
});

it('allows forcing media type', function () {
    $action = MediaAction::make('test')
        ->media('https://example.com/unknown-file')
        ->mediaType('video');
    
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('detectMediaType');
    $method->setAccessible(true);
    
    $result = $method->invoke($action);
    
    expect($result)->toBe('video');
});

it('supports additional video formats', function () {
    $formats = ['mkv', 'flv', 'wmv', '3gp', 'ogv', 'm4v'];
    
    foreach ($formats as $format) {
        $action = MediaAction::make('test')
            ->media("https://example.com/video.{$format}");
        
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('getMediaType');
        $method->setAccessible(true);
        
        $result = $method->invoke($action, "https://example.com/video.{$format}");
        
        expect($result)->toBe('video');
    }
});

it('handles local URLs gracefully when headers fail', function () {
    $action = MediaAction::make('test')
        ->media('https://local.test/video-without-extension');
    
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('getMediaType');
    $method->setAccessible(true);
    
    // This should not throw an exception and should return 'unknown'
    $result = $method->invoke($action, 'https://local.test/video-without-extension');
    
    expect($result)->toBe('unknown');
});
