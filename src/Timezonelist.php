<?php

namespace Jackiedo\Timezonelist;

use DateTime;
use DateTimeZone;

/**
 * The Timezonelist class.
 *
 * @package Jackiedo\Timezonelist
 *
 * @author Jackie Do <anhvudo@gmail.com>
 */
class Timezonelist
{
    /**
     * HTML entities.
     */
    public const MINUS      = '&#8722;';
    public const PLUS       = '&#43;';
    public const WHITESPACE = '&#160;';

    /**
     * General timezones.
     *
     * @var array
     */
    protected $generalTimezones = [
        'GMT' => 'GMT timezone',
        'UTC' => 'UTC timezone',
    ];

    /**
     * All continents of the world.
     *
     * @var array
     */
    protected $continents = [
        'Africa'     => DateTimeZone::AFRICA,
        'America'    => DateTimeZone::AMERICA,
        'Antarctica' => DateTimeZone::ANTARCTICA,
        'Arctic'     => DateTimeZone::ARCTIC,
        'Asia'       => DateTimeZone::ASIA,
        'Atlantic'   => DateTimeZone::ATLANTIC,
        'Australia'  => DateTimeZone::AUSTRALIA,
        'Europe'     => DateTimeZone::EUROPE,
        'Indian'     => DateTimeZone::INDIAN,
        'Pacific'    => DateTimeZone::PACIFIC,
    ];

    /**
     * Create a GMT timezone select element for form.
     *
     * @param string            $name       The name of the select tag
     * @param null|string       $selected   The selected value
     * @param null|array|string $attr       The HTML attributes of select thag
     * @param bool              $htmlencode Use HTML entities for values of select tag
     *
     * @return string
     */
    public function create($name, $selected = null, $attr = null, $htmlencode = true)
    {
        // Attributes for select element
        $attrSet = null;

        if (!empty($attr)) {
            if (is_array($attr)) {
                foreach ($attr as $attr_name => $attr_value) {
                    $attrSet .= ' ' . $attr_name . '="' . $attr_value . '"';
                }
            } else {
                $attrSet = ' ' . $attr;
            }
        }

        // start select element
        $listbox = '<select name="' . $name . '"' . $attrSet . '>';

        // Add popular timezones
        if (!empty($this->generalTimezones)) {
            // start optgroup tag
            $listbox .= '<optgroup label="General">';

            foreach ($this->generalTimezones as $key => $value) {
                $selected_attr = ($selected == $key) ? ' selected="selected"' : '';

                $listbox .= '<option value="' . $key . '"' . $selected_attr . '>';
                $listbox .= $value;
                $listbox .= '</option>';
            }

            // end optgroup tag
            $listbox .= '</optgroup>';
        }

        // Add all timezone of continents
        foreach ($this->continents as $continent => $mask) {
            $timezones = DateTimeZone::listIdentifiers($mask);

            // start optgroup tag
            $listbox .= '<optgroup label="' . $continent . '">';

            // create option tags
            foreach ($timezones as $timezone) {
                $selected_attr = ($selected == $timezone) ? ' selected="selected"' : '';

                $listbox .= '<option value="' . $timezone . '"' . $selected_attr . '>';
                $listbox .= $this->formatTimezone($timezone, $continent, $htmlencode);
                $listbox .= '</option>';
            }

            // end optgroup tag
            $listbox .= '</optgroup>';
        }

        // end select element
        $listbox .= '</select>';

        return $listbox;
    }

    /**
     * Create a timezone array.
     *
     * @param bool $htmlencode Use HTML entities for items
     *
     * @return mixed
     */
    public function toArray($htmlencode = true)
    {
        $list = [];

        // Add popular timezones to list
        if (!empty($this->generalTimezones)) {
            $list['General'] = $this->generalTimezones;
        }

        // Add all timezone of continents to list
        foreach ($this->continents as $continent => $mask) {
            $timezones = DateTimeZone::listIdentifiers($mask);

            foreach ($timezones as $timezone) {
                $list[$continent][$timezone] = $this->formatTimezone($timezone, $continent, $htmlencode);
            }
        }

        return $list;
    }

    /**
     * Format to display timezones.
     *
     * @param string $timezone
     * @param string $continent
     * @param bool   $htmlencode
     *
     * @return string
     */
    protected function formatTimezone($timezone, $continent, $htmlencode = true)
    {
        // The replacement
        $replacement = [
            'offset' => [
                'search'  => ['-', '+'],
                'replace' => $htmlencode ? [' ' . self::MINUS . ' ', ' ' . self::PLUS . ' '] : [' - ', ' + '],
            ],
            'timezone' => [
                'search'  => ['St_', '_'],
                'replace' => ['St. ', ' '],
            ],
        ];

        // Identify returned parts
        $time     = new DateTime('', new DateTimeZone($timezone));
        $offset   = $time->format('P');
        $timezone = substr($timezone, strlen($continent) + 1);

        // Replace returned parts using replacement
        $offset   = str_replace($replacement['offset']['search'], $replacement['offset']['replace'], $offset);
        $timezone = str_replace($replacement['timezone']['search'], $replacement['timezone']['replace'], $timezone);

        return '(GMT/UTC' . $offset . ')' . ($htmlencode ? str_repeat(self::WHITESPACE, 5) : ' ') . $timezone;
    }
}
