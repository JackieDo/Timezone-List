<?php

namespace Jackiedo\Timezonelist\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Timezonelist facade.
 *
 * @method static \Jackiedo\Timezonelist\Timezonelist onlyGroups(array $groups=[])                                                   Set the filter of the groups want to get.
 * @method static \Jackiedo\Timezonelist\Timezonelist excludeGroups(array $groups=[])                                                Set the filter of the groups do not want to get.
 * @method static \Jackiedo\Timezonelist\Timezonelist splitGroup(bool $status=true)                                                  Decide whether to split group or not.
 * @method statis \Jackiedo\Timezonelist\Timezonelist showOffset(bool $status=true)                                                  Decide whether to show the offset or not.
 * @method static \Jackiedo\Timezonelist\Timezonelist reset()                                                                        Return new static to reset all config.
 * @method static string toSelectBox(string $name, null|string $selected=null, null|array|string $attrs=null, bool $htmlencode=true) Create a select box of timezones.
 * @method static string create(string $name, null|string $selected=null, null|array|string $attrs=null, bool $htmlencode=true)      Alias of the `toSelectBox()` method.
 * @method static array toArray(bool $htmlencode=true)                                                                               Create an array of timezones.
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
