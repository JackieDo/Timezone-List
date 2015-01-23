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
    
    /**
     * Create a GMT timezone list box
     * 
     * 
     **/
    public static function create($name, $selected='', $attr='') {
        
        // List of all continents in the world
        $continents = array(
            'Africa' => DateTimeZone::AFRICA,
            'America' => DateTimeZone::AMERICA,
            'Antarctica' => DateTimeZone::ANTARCTICA,
            'Arctic' => DateTimeZone::ARCTIC,
            'Asia' => DateTimeZone::ASIA,
            'Atlantic' => DateTimeZone::ATLANTIC,
            'Australia' => DateTimeZone::AUSTRALIA,
            'Europe' => DateTimeZone::EUROPE,
            'Indian' => DateTimeZone::INDIAN,
            'Pacific' => DateTimeZone::PACIFIC
        );
        
        // Create listbox
        $attrSet = (!empty($attr)) ? ' ' . $attr : '';
        $listbox = '<select name="' .$name. '"' .$attrSet. '>' . "\n";
        foreach ($continents as $name => $mask) {
            $zones = DateTimeZone::listIdentifiers($mask);
            $listbox .= "\t" . '<optgroup label="' .$name. '">' . "\n";
            foreach ($zones as $timezone) {
                // Lets sample the time there right now
            	$time = new DateTime(NULL, new DateTimeZone($timezone));
                
                // selected atribute
                $selected_attr = ($selected == $timezone) ? ' selected="selected"' : '';
                
                // Create options tag
                $listbox .= "\t\t" . '<option value="' .$timezone. '"' .$selected_attr. '>';
                $listbox .= '(GMT' . $time->format('P') . ')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . str_replace('_', ' ', substr($timezone, strlen($name) + 1));
                $listbox .= '</option>' . "\n";
            }
            $listbox .= "\t" . '</optgroup>' . "\n";
            
            // Add two option general: UTC and GMT
            $listbox .= "\t" . '<optgroup label="General">' . "\n";
            $listbox .= "\t\t" . '<option value="UTC"';
            if ($selected == 'UTC') {
                $listbox .= ' selected="selected"';
            }
            $listbox .= '>(UTC)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UTC timezone';
            $listbox .= '</option>' . "\n";
            $listbox .= "\t\t" . '<option value="GMT"';
            if ($selected == 'GMT') {
                $listbox .= ' selected="selected"';
            }
            $listbox .= '>(GMT)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GMT timezone';
            $listbox .= '</option>' . "\n";
            $listbox .= "\t" . '</optgroup>' . "\n";
        }
        $listbox .= '</select>' . "\n";
        
        // return lisbox
        return $listbox;
    }
}

?>