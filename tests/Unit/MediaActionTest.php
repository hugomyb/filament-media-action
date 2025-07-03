<?php

use Hugomyb\FilamentMediaAction\Actions\MediaAction;

it('can be instantiated', function () {
    $action = MediaAction::make('test');

    expect($action)->toBeInstanceOf(MediaAction::class);
});

it('has the correct default name', function () {
    expect(MediaAction::getDefaultName())->toBe('media');
});

it('can be created with a custom name', function () {
    $action = MediaAction::make('custom-name');

    expect($action->getName())->toBe('custom-name');
});

it('can be created with a label', function () {
    $action = MediaAction::make('test')
        ->label('Test Label');

    expect($action->getLabel())->toBe('Test Label');
});

it('can be created with an icon', function () {
    $action = MediaAction::make('test')
        ->icon('heroicon-o-video-camera');

    expect($action->getIcon())->toBe('heroicon-o-video-camera');
});

it('can be created as an icon button', function () {
    $action = MediaAction::make('test')
        ->iconButton();

    expect($action->isIconButton())->toBeTrue();
});

it('can have a custom modal heading', function () {
    $action = MediaAction::make('test')
        ->modalHeading('Custom Heading');

    expect($action->getModalHeading())->toBe('Custom Heading');
});

it('can have a custom modal description', function () {
    $action = MediaAction::make('test')
        ->modalDescription('Custom Description');

    expect($action->getModalDescription())->toBe('Custom Description');
});

it('can have a custom modal width', function () {
    $action = MediaAction::make('test')
        ->modalWidth('xl');

    expect($action->getModalWidth())->toBe('xl');
});

it('can set extra modal footer actions', function () {
    $action = MediaAction::make('test');

    expect(method_exists($action, 'extraModalFooterActions'))->toBeTrue();
});
