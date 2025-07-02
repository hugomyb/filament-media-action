<?php

namespace Hugomyb\FilamentMediaAction\Tests\Support;

use Hugomyb\FilamentMediaAction\Actions\MediaAction;

class TestMediaAction extends MediaAction
{
    public function getMediaType(?string $url): ?string
    {
        return parent::getMediaType($url);
    }
}
