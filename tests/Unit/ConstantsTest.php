<?php

use Hugomyb\FilamentMediaAction\Actions\MediaAction;

it('exposes media type constants with expected values', function () {
    expect(MediaAction::TYPE_YOUTUBE)->toBe('youtube');
    expect(MediaAction::TYPE_AUDIO)->toBe('audio');
    expect(MediaAction::TYPE_VIDEO)->toBe('video');
    expect(MediaAction::TYPE_IMAGE)->toBe('image');
    expect(MediaAction::TYPE_PDF)->toBe('pdf');
    expect(MediaAction::TYPE_UNKNOWN)->toBe('unknown');
});

