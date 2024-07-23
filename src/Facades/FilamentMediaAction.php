<?php

namespace Hugomyb\FilamentMediaAction\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hugomyb\FilamentMediaAction\FilamentMediaAction
 */
class FilamentMediaAction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Hugomyb\FilamentMediaAction\FilamentMediaAction::class;
    }
}
