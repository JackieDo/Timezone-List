<?php

namespace Jackiedo\Timezonelist\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Timezonelist facade.
 *
 * @method static string create(string $name, null|string $selected = null, null|array|string $attr = null, bool $htmlencode = true)
 * @method static array toArray(bool $htmlencode = true)
 *
 * @see \Jackiedo\Timezonelist\Timezonelist
 */
class Timezonelist extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'timezonelist';
    }
}
