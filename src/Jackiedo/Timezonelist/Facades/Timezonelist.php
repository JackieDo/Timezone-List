<?php namespace Jackiedo\Timezonelist\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Timezonelist
 *
 * @package    jackiedo/timezonelist
 * @subpackage facades
 * @author     Jackie Do <anhvudo@gmail.com>
 * @copyright  2015 Jackie Do
 */

class Timezonelist extends Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'timezonelist'; }

}

?>