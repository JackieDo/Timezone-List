<?php namespace Jackiedo\Timezonelist;

use DateTimeZone;
use DateTime;

/**
 * Timezonelist
 *
 * @package    jackiedo/timezonelist
 * @author     Jackie Do <anhvudo@gmail.com>
 * @copyright  2015 Jackie Do
 */

class Timezonelist {
    protected static $continents = array(
        'Africa'        => DateTimeZone::AFRICA,
        'America'       => DateTimeZone::AMERICA,
        'Antarctica'    => DateTimeZone::ANTARCTICA,
        'Arctic'        => DateTimeZone::ARCTIC,
        'Asia'          => DateTimeZone::ASIA,
        'Atlantic'      => DateTimeZone::ATLANTIC,
        'Australia'     => DateTimeZone::AUSTRALIA,
        'Europe'        => DateTimeZone::EUROPE,
        'Indian'        => DateTimeZone::INDIAN,
        'Pacific'       => DateTimeZone::PACIFIC
    );

    const WHITESPACE_SEP = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    /**
     * Create a GMT timezone select element for form
     *
     * @param string $name
     * @param string $selected
     * @param mixed $attr
     * @return string
     **/
    public static function create($name, $selected='', $attr='') {

        // Create listbox
        $attrSet = null;
        if (!empty($attr)) {
            if (is_array($attr)) {
                foreach ($attr as $attr_name => $attr_value) {
                    $attrSet .= ' ' .$attr_name. '="' .$attr_value. '"';
                }
            } else {
                $attrSet = ' ' .$attr;
            }
        }
        $listbox = '<select name="' .$name. '"' .$attrSet. '>' . "\n";
        foreach (self::$continents as $name => $mask) {
            $zones = DateTimeZone::listIdentifiers($mask);
            $listbox .= "\t" . '<optgroup label="' .$name. '">' . "\n";
            foreach ($zones as $timezone) {
                // Lets sample the time there right now
            	$time = new DateTime(NULL, new DateTimeZone($timezone));

                // selected atribute
                $selected_attr = ($selected == $timezone) ? ' selected="selected"' : '';

                // Create options tag
                $listbox .= "\t\t" . '<option value="' .$timezone. '"' .$selected_attr. '>';
                $listbox .= '(GMT' . $time->format('P') . ')' . self::WHITESPACE_SEP . str_replace('_', ' ', substr($timezone, strlen($name) + 1));
                $listbox .= '</option>' . "\n";
            }
            $listbox .= "\t" . '</optgroup>' . "\n";
        }

        // Add two options general: UTC and GMT
        $listbox .= "\t" . '<optgroup label="General">' . "\n";
        $listbox .= "\t\t" . '<option value="UTC"';
        if ($selected == 'UTC') {
            $listbox .= ' selected="selected"';
        }
        $listbox .= '>(UTC)' . self::WHITESPACE_SEP . 'UTC timezone';
        $listbox .= '</option>' . "\n";
        $listbox .= "\t\t" . '<option value="GMT"';
        if ($selected == 'GMT') {
            $listbox .= ' selected="selected"';
        }
        $listbox .= '>(GMT)' . self::WHITESPACE_SEP . 'GMT timezone';
        $listbox .= '</option>' . "\n";
        $listbox .= "\t" . '</optgroup>' . "\n";
        $listbox .= '</select>' . "\n";

        // return lisbox
        return $listbox;
    }

    /**
     * Create a timezone array
     *
     * @return mixed
     **/
    public static function toArray() {

        // Create $timezones array
        $timezones = array();
        foreach (self::$continents as $name => $mask) {
            $zones = DateTimeZone::listIdentifiers($mask);
            foreach ($zones as $timezone) {
                // Lets sample the time there right now
            	$time = new DateTime(NULL, new DateTimeZone($timezone));

                // Add timezone into $timezone array
                $timezones[$name][$timezone] = '(GMT' . $time->format('P') . ')' . self::WHITESPACE_SEP . str_replace('_', ' ', substr($timezone, strlen($name) + 1));
            }
        }

        // Add two elements general: UTC and GMT to $timezones array
        $timezones['General']['UTC'] = '(UTC)' . self::WHITESPACE_SEP . 'UTC timezone';
        $timezones['General']['GMT'] = '(GMT)' . self::WHITESPACE_SEP . 'GMT timezone';

        // return $timezones array
        return $timezones;
    }
}

?>