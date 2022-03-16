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
        'GMT',
        'UTC',
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
     * The filter of the groups to get.
     *
     * @var array
     */
    protected $groupsFilter = [];

    /**
     * Status of grouping the return list.
     *
     * @var bool
     */
    protected $splitGroup = true;

    /**
     * Status of showing timezone offset.
     *
     * @var bool
     */
    protected $showOffset = true;

    /**
     * The offset prefix in list.
     *
     * @var string
     */
    protected $offsetPrefix = 'GMT/UTC';

    /**
     * Set the filter of the groups want to get.
     *
     * @param array $groups
     *
     * @return $this
     */
    public function onlyGroups($groups = [])
    {
        $this->groupsFilter = $groups;

        return $this;
    }

    /**
     * Set the filter of the groups do not want to get.
     *
     * @param array $groups
     *
     * @return $this
     */
    public function excludeGroups($groups = [])
    {
        if (empty($groups)) {
            $this->groupsFilter = [];

            return $this;
        }

        $this->groupsFilter = array_values(array_diff(array_keys($this->continents), $groups));

        if (!in_array('General', $groups)) {
            $this->groupsFilter[] = 'General';
        }

        return $this;
    }

    /**
     * Decide whether to split group or not.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function splitGroup($status = true)
    {
        $this->splitGroup = (bool) $status;

        return $this;
    }

    /**
     * Decide whether to show the offset or not.
     *
     * @param bool $status
     *
     * @return $this
     */
    public function showOffset($status = true)
    {
        $this->showOffset = (bool) $status;

        return $this;
    }

    /**
     * Return new static to reset all config.
     *
     * @return $this
     */
    public function new()
    {
        return new static;
    }

    /**
     * Create a select box of timezones.
     *
     * @param string            $name       The name of the select tag
     * @param null|string       $selected   The selected value
     * @param null|array|string $attr       The HTML attributes of select tag
     * @param bool              $htmlencode Use HTML entities for values of select tag
     *
     * @return string
     */
    public function toSelectBox($name, $selected = null, $attr = null, $htmlencode = true)
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

        $listbox = '<select name="' . $name . '"' . $attrSet . '>';
        $listbox .= (!$this->splitGroup ? $this->genOptWithoutGroup($selected, $htmlencode) : $this->genOptWithGroup($selected, $htmlencode));
        $listbox .= '</select>';

        return $listbox;
    }

    /**
     * Alias of the `toSelectBox()` method.
     *
     * @param string            $name       The name of the select tag
     * @param null|string       $selected   The selected value
     * @param null|array|string $attr       The HTML attributes of select tag
     * @param bool              $htmlencode Use HTML entities for values of select tag
     *
     * @return string
     */
    public function create($name, $selected = null, $attr = null, $htmlencode = true)
    {
        return $this->toSelectBox($name, $selected, $attr, $htmlencode);
    }

    /**
     * Create an array of timezones.
     *
     * @param bool $htmlencode Use HTML entities for items
     *
     * @return mixed
     */
    public function toArray($htmlencode = true)
    {
        $list = [];

        // If do not group the return list
        if (!$this->splitGroup) {
            if ($this->includeGeneral()) {
                foreach ($this->generalTimezones as $timezone) {
                    $list[$timezone] = $this->formatTimezone($timezone, null, $htmlencode);
                }
            }

            foreach ($this->loadContinents() as $continent => $mask) {
                $timezones = DateTimeZone::listIdentifiers($mask);

                foreach ($timezones as $timezone) {
                    $list[$timezone] = $this->formatTimezone($timezone, null, $htmlencode);
                }
            }

            return $list;
        }

        // If group the return list
        if ($this->includeGeneral()) {
            $list['General'] = array_map(function ($timezone) use ($htmlencode) {
                return $this->formatTimezone($timezone, null, $htmlencode);
            }, $this->generalTimezones);
        }

        foreach ($this->loadContinents() as $continent => $mask) {
            $timezones = DateTimeZone::listIdentifiers($mask);

            foreach ($timezones as $timezone) {
                $list[$continent][$timezone] = $this->formatTimezone($timezone, $continent, $htmlencode);
            }
        }

        return $list;
    }

    /**
     * Generate option tag with the optgroup tag.
     *
     * @param string $selected
     * @param bool   $htmlencode
     *
     * @return string
     */
    protected function genOptWithGroup($selected, $htmlencode = true)
    {
        $output = null;

        if ($this->includeGeneral()) {
            $output .= '<optgroup label="General">';

            foreach ($this->generalTimezones as $timezone) {
                $attrs = ($selected == $timezone) ? 'selected="selected"' : '';
                $output .= $this->genOptionTag($timezone, $attrs, $this->formatTimezone($timezone, null, $htmlencode));
            }

            $output .= '</optgroup>';
        }

        foreach ($this->loadContinents() as $continent => $mask) {
            $timezones = DateTimeZone::listIdentifiers($mask);
            $output .= '<optgroup label="' . $continent . '">';

            foreach ($timezones as $timezone) {
                $attrs = ($selected == $timezone) ? 'selected="selected"' : '';
                $output .= $this->genOptionTag($timezone, $attrs, $this->formatTimezone($timezone, $continent, $htmlencode));
            }

            $output .= '</optgroup>';
        }

        return $output;
    }

    /**
     * Generate option tag without the optgroup tag.
     *
     * @param string $selected
     * @param bool   $htmlencode
     *
     * @return string
     */
    protected function genOptWithoutGroup($selected, $htmlencode = true)
    {
        $output = null;

        if ($this->includeGeneral()) {
            foreach ($this->generalTimezones as $timezone) {
                $attrs = ($selected == $timezone) ? 'selected="selected"' : '';
                $output .= $this->genOptionTag($timezone, $attrs, $this->formatTimezone($timezone, null, $htmlencode));
            }
        }

        // start adding all timezone of continents
        foreach ($this->loadContinents() as $continent => $mask) {
            $timezones = DateTimeZone::listIdentifiers($mask);

            foreach ($timezones as $timezone) {
                $attrs = ($selected == $timezone) ? 'selected="selected"' : '';
                $output .= $this->genOptionTag($timezone, $attrs, $this->formatTimezone($timezone, null, $htmlencode));
            }
        }
        // end adding all timezone of continents

        return $output;
    }

    /**
     * Generate the option HTML tag.
     *
     * @param string $value
     * @param string $attr
     * @param string $display
     *
     * @return string
     */
    protected function genOptionTag($value, $attr, $display)
    {
        $attr   = (string) (!empty($attr) ? ' ' . $attr : '');
        $output = '';

        $output .= '<option value="' . (string) $value . '"' . $attr . '>';
        $output .= $display;
        $output .= '</option>';

        return $output;
    }

    /**
     * DetermineCheck if the general timezones is loaded in the returned result.
     *
     * @return bool
     */
    protected function includeGeneral()
    {
        return empty($this->groupsFilter) || in_array('General', $this->groupsFilter);
    }

    /**
     * Load filtered continents.
     *
     * @return array
     */
    protected function loadContinents()
    {
        if (empty($this->groupsFilter)) {
            return $this->continents;
        }

        return array_filter($this->continents, function ($key) {
            return in_array($key, $this->groupsFilter);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Format to display timezones.
     *
     * @param string      $timezone
     * @param null|string $cutOffContinent
     * @param bool        $htmlencode
     *
     * @return string
     */
    protected function formatTimezone($timezone, $cutOffContinent = null, $htmlencode = true)
    {
        $displayedTimezone  = empty($cutOffContinent) ? $timezone : substr($timezone, strlen($cutOffContinent) + 1);
        $normalizedTimezone = $this->normalizeTimezone($displayedTimezone, $htmlencode);

        if (!$this->showOffset) {
            return $normalizedTimezone;
        }

        $notmalizedOffset = $this->normalizeOffset($this->getOffset($timezone), $htmlencode);
        $separator        = $this->normalizeSeparator($htmlencode);

        return '(' . $this->offsetPrefix . $notmalizedOffset . ')' . $separator . $normalizedTimezone;
    }

    /**
     * Normalize the offset.
     *
     * @param string $offset
     * @param bool   $htmlencode
     *
     * @return string
     */
    protected function normalizeOffset($offset, $htmlencode = true)
    {
        $search  = ['-', '+'];
        $replace = $htmlencode ? [' ' . self::MINUS . ' ', ' ' . self::PLUS . ' '] : [' - ', ' + '];

        return str_replace($search, $replace, $offset);
    }

    /**
     * Normalize the timezone.
     *
     * @param string $timezone
     * @param bool   $htmlencode
     *
     * @return string
     */
    protected function normalizeTimezone($timezone, $htmlencode = true)
    {
        $search  = ['St_', '/', '_'];
        $replace = ['St. ', ' / ' . ' '];

        return str_replace($search, $replace, $timezone);
    }

    /**
     * Normalize the separator beetween the timezone and offset.
     *
     * @param bool $htmlencode
     *
     * @return string
     */
    protected function normalizeSeparator($htmlencode = true)
    {
        return $htmlencode ? str_repeat(self::WHITESPACE, 5) : ' ';
    }

    /**
     * Get the timezone offset.
     *
     * @param string $timezone
     *
     * @return string
     */
    protected function getOffset($timezone)
    {
        $time = new DateTime('', new DateTimeZone($timezone));

        return $time->format('P');
    }

    /**
     * Get the difference of timezone to Coordinated Universal Time (UTC).
     *
     * @param string $timezone
     *
     * @return string
     */
    protected function getUTCOffset($timezone)
    {
        $dateTimeZone = new DateTimeZone($timezone);
        $utcTime      = new DateTime('', new DateTimeZone('UTC'));
        $offset       = $dateTimeZone->getOffset($utcTime);
        $format       = gmdate('H:i', abs($offset));

        return $offset >= 0 ? "+{$format}" : "-{$format}";
    }
}
