# Laravel Timezone List

[![Fix coding standards](https://github.com/JackieDo/Timezone-List/actions/workflows/fix-coding-standards.yml/badge.svg?branch=5.x)](https://github.com/JackieDo/Timezone-List/actions/workflows/fix-coding-standards.yml)
[![Latest Stable Version](https://poser.pugx.org/jackiedo/timezonelist/v/stable)](https://packagist.org/packages/jackiedo/timezonelist)
[![Total Downloads](https://poser.pugx.org/jackiedo/timezonelist/downloads)](https://packagist.org/packages/jackiedo/timezonelist)
[![License](https://poser.pugx.org/jackiedo/timezonelist/license)](https://packagist.org/packages/jackiedo/timezonelist)

# Overview

- [Laravel Timezone List](#laravel-timezone-list)
- [Overview](#overview)
- [Feature](#feature)
- [Versions and compatibility](#versions-and-compatibility)
- [Documentation](#documentation)
  - [Installation](#installation)
    - [Step 1 - Require Package](#step-1---require-package)
    - [Step 2 - Register Service Provider](#step-2---register-service-provider)
    - [Step 3 - Register Facade Alias](#step-3---register-facade-alias)
  - [Usage](#usage)
    - [Working With Facade](#working-with-facade)
    - [Using As Regular Class](#using-as-regular-class)
  - [Available Methods](#available-methods)
    - [Render a timezone listbox](#render-a-timezone-listbox)
    - [Render a timezone array](#render-a-timezone-array)
    - [Filter the returned list](#filter-the-returned-list)
      - [Get only some specified groups](#get-only-some-specified-groups)
      - [Exclude some specified groups](#exclude-some-specified-groups)
    - [Change the layout of the returned list](#change-the-layout-of-the-returned-list)
      - [Decide whether to split group or not](#decide-whether-to-split-group-or-not)
      - [Decide whether to show the timezone offset or not](#decide-whether-to-show-the-timezone-offset-or-not)
    - [Reset all config and return new list](#reset-all-config-and-return-new-list)
- [Contributors](#contributors)
- [License](#license)

# Feature
- Render a timezone listbox (select element) in Laravel
- Render a timezone array in Laravel

# Versions and compatibility

Currently, there are some branches of Timezone-List is compatible with the following version of Laravel framework

| Timezone-List branch                                      | Laravel version |
| --------------------------------------------------------- | --------------- |
| [4.x](https://github.com/JackieDo/Timezone-List/tree/4.x) | 4.x             |
| [5.x](https://github.com/JackieDo/Timezone-List/tree/5.x) | 5.x and later   |

> This documentation is use for branch 5.x

# Documentation

## Installation

You can install this package through [Composer](https://getcomposer.org) with the following steps:

### Step 1 - Require Package

At the root of your application directory, run the following command (in any terminal client):

```shell
$ composer require jackiedo/timezonelist
```

> **Note:** Since Laravel 5.5, [service providers and aliases are automatically registered](https://laravel.com/docs/5.5/packages#package-discovery). But if you are using Laravel 5.4 and earlier, you must register the Service Provider and the Facade manually. Do the following steps:

### Step 2 - Register Service Provider

Open `config/app.php`, and add a new line to the providers section:

```php
...
Jackiedo\Timezonelist\TimezonelistServiceProvider::class,
```

### Step 3 - Register Facade Alias
Add the following line to the aliases section in file `config/app.php`:

```php
'Timezonelist' => Jackiedo\Timezonelist\Facades\Timezonelist::class,
```

## Usage

### Working With Facade

Laravel Timezone List has a facade with the fully qualified namespace is `Jackiedo\Timezonelist\Facades\Timezonelist`. You can perform all operations through this facade.

**Example:**

```php
<?php

namespace Your\Namespace;

use Jackiedo\Timezonelist\Facades\Timezonelist;

class YourClass
{
    public function yourMethod()
    {
        $return = Timezonelist::doSomething();
    }
}

```

> **Note:** If at the installation step, you have registered the Facde alias, then in the areas where the namespace is not used, eg views..., you can completely use that Facde alias to use instead of having to use the fully qualified Facde namespace.

**Example:** _(use in the `resources/views/demo.blade.php` file)_

```php
<div class="form-group">
    {!! Timezonelist::doSomething() !!}
</div>
```

### Using As Regular Class

You can completely use the package through the `Jackiedo\Timezonelist\Timezonelist` class like using a regular object class.

**Example:**

```php
namespace Your\Namespace;

use Jackiedo\Timezonelist\Timezonelist;

class YourClass
{
    public function yourMethod()
    {
        $timezoneList = new Timezonelist;

        $return = $timezoneList->doSomething();
    }
}

```

## Available Methods

### Render a timezone listbox

**Syntax:**

```php
/**
 * Create a select box of timezones.
 *
 * @param string            $name       The name of the select tag
 * @param null|string       $selected   The selected value
 * @param null|array|string $attr       The HTML attributes of select thag
 * @param bool              $htmlencode Use HTML entities for values of select tag
 *
 * @return string
 */
public function toSelectBox($name, $selected = null, $attr = null, $htmlencode = true);

/**
 * Alias of the `toSelectBox()` method.
 *
 * @deprecated 6.0.0 This method name no longer matches the semantics
 */
public function create($name, $selected = null, $attr = null, $htmlencode = true);
```
> Note: the `create()` method will be removed in the version 6.x

**Example:**

```php
echo Timezonelist::toSelectBox('timezone');
```

This will output the following HTML code:

```html
<select name="timezone">
    <optgroup label="General">
        <option value="GMT">GMT timezone</option>
        <option value="UTC">UTC timezone</option>
    </optgroup>
    <optgroup label="Africa">
        <option value="Africa/Abidjan">(GMT/UTC + 00:00) Abidjan</option>
        <option value="Africa/Accra">(GMT/UTC + 00:00) Accra</option>
        <option value="Africa/Addis_Ababa">(GMT/UTC + 03:00) Addis Ababa</option>
        <option value="Africa/Algiers">(GMT/UTC + 01:00) Algiers</option>
        <option value="Africa/Asmara">(GMT/UTC + 03:00) Asmara</option>
        <option value="Africa/Bamako">(GMT/UTC + 00:00) Bamako</option>
        <option value="Africa/Bangui">(GMT/UTC + 01:00) Bangui</option>
        <option value="Africa/Banjul">(GMT/UTC + 00:00) Banjul</option>
        <option value="Africa/Bissau">(GMT/UTC + 00:00) Bissau</option>

        ...
    </optgroup>
    <optgroup label="America">
        <option value="America/Adak">(GMT/UTC - 10:00) Adak</option>
        <option value="America/Anchorage">(GMT/UTC - 09:00) Anchorage</option>
        <option value="America/Anguilla">(GMT/UTC - 04:00) Anguilla</option>
        <option value="America/Antigua">(GMT/UTC - 04:00) Antigua</option>
        <option value="America/Araguaina">(GMT/UTC - 03:00) Araguaina</option>
        <option value="America/Argentina/Buenos_Aires">(GMT/UTC - 03:00) Argentina/Buenos Aires</option>
        <option value="America/Argentina/Catamarca">(GMT/UTC - 03:00) Argentina/Catamarca</option>
        <option value="America/Argentina/Cordoba">(GMT/UTC - 03:00) Argentina/Cordoba</option>
        <option value="America/Argentina/Jujuy">(GMT/UTC - 03:00) Argentina/Jujuy</option>

        ...
    </optgroup>

    ...
</select>
```

> The `Timezonelist::toSelectBox()` method has four parameters:

- The first parameter is required, it is the name attribute of the rendered select tag
- The second parameter use to set selected value of list box.
- The third parameter use to set HTML attribute of select tag.
- The fourth parameter allow to use some HTML entities in the rendered select tag. The purpose is to make the element look better.

**Example:**

```php
// Render a select tag with the name `timezone` and the `Africa/Asmara` option preselected
Timezonelist::toSelectBox('timezone', 'Africa/Asmara');

// Render tag with some HTML attributes
Timezonelist::toSelectBox('timezone', null, [
    'id'    => 'timezone',
    'class' => 'styled',
    ...
]);

// Or with other method
Timezonelist::toSelectBox('timezone', null, 'id="timezone" class="styled"');
```

> Example of the difference of the `fourth parameter`

![Example-render-select-tag](https://user-images.githubusercontent.com/9862115/158339796-c58a6447-8564-4976-a4e7-2b7f9807276d.jpg)

### Render a timezone array

**Syntax:**

```php
/**
 * Create a timezone array.
 *
 * @param bool $htmlencode Use HTML entities for items
 *
 * @return mixed
 */
public function toArray($htmlencode = true);
```

**Example:**

```php
$timezoneList = Timezonelist::toArray(false);

// The returned list will be
// [
//     "General" => [
//         "GMT" => "(GMT/UTC + 00:00) GMT",
//         "UTC" => "(GMT/UTC + 00:00) UTC",
//     ],
//     "Africa" => [
//         "Africa/Abidjan "    => "(GMT/UTC + 00:00) Abidjan",
//         "Africa/Accra"       => "(GMT/UTC + 00:00) Accra",
//         "Africa/Addis_Ababa" => "(GMT/UTC + 03:00) AddisAbaba",
//         "Africa/Algiers"     => "(GMT/UTC + 01:00) Algiers",
//         "Africa/Asmara"      => "(GMT/UTC + 03:00) Asmara",
//         ...
//     ],
//     "America" => [
//         "America/Adak"      => "(GMT/UTC - 09:00) Adak",
//         "America/Anchorage" => "(GMT/UTC - 08:00) Anchorage",
//         "America/Anguilla"  => "(GMT/UTC - 04:00) Anguilla",
//         "America/Antigua"   => "(GMT/UTC - 04:00) Antigua",
//         "America/Araguaina" => "(GMT/UTC - 03:00) Araguaina",
//         ...
//     ],
//     ...
// ]
```

### Filter the returned list

By default, the `toSelectBox`, `toArray`... methods will return a list of timezones consisting of 11 groups (one common group and 10 groups corresponding to the continents):

- General
- Africa
- America
- Antarctica
- Arctic
- Asia
- Atlantic
- Australia
- Europe
- Indian
- Pacific

In some cases, we don't want to get in that list some specified groups, we can do that by some of the following methods:

#### Get only some specified groups

**Syntax:**

```php
/**
 * Set the filter of the groups want to get.
 *
 * @param array $groups
 *
 * @return $this
 */
public function onlyGroups($groups = []);
```

**Example:**

```php
...
$return = Timezonelist::onlyGroups(['Asia', 'America'])->toSelectBox('timezone');
```

#### Exclude some specified groups

**Syntax:**

```php
/**
 * Set the filter of the groups do not want to get.
 *
 * @param array $groups
 *
 * @return $this
 */
public function excludeGroups($groups = []);
```

**Example:**

```php
...
$return = Timezonelist::excludeGroups(['General'])->toArray();
```

### Change the layout of the returned list

In some cases, we need to change the form of the list that we will receive, we can do it through some of the following methods:

#### Decide whether to split group or not

**Syntax:**

```php
/**
 * Decide whether to split group or not.
 *
 * @param bool $status
 *
 * @return $this
 */
public function splitGroup($status = true);
```

**Example:**

```php
$return = Timezonelist::splitGroup(false)->excludeGroups(['General'])->toSelectBox('timezone');
```

#### Decide whether to show the timezone offset or not

**Syntax:**

```php
/**
 * Decide whether to show the offset or not.
 *
 * @param bool $status
 *
 * @return $this
 */
public function showOffset($status = true);
```

**Example:**

```php
$return = Timezonelist::showOffset(false)->excludeGroups(['General'])->toSelectBox('timezone');
```

### Reset all config and return new list

Always keep in mind that, if we use package methods via Facade, we are using it as a `static` interface to a class. This means that the filter and layout settings will always be saved for the next call. If we don't want to reuse these settings, we have to execute the following method on the next call:

**Syntax:**

```php
/**
 * Return new static to reset all config.
 *
 * @return $this
 */
public function reset();
```

**Example:**

```php
// Genrate one select box, exclude two groups of timezones, Asia and Africa
$selectBox = Timezonelist::excludeGroups(['Asia', 'Africa'])->toSelectBox('timezone');

$list1 = Timezonelist::toArray();         // Two groups, Asia and Africa, will not be loaded into the result
$list2 = Timezonelist::reset()->toArray() // All groups will be loaded
```

# Contributors
This project exists thanks to all its [contributors](https://github.com/JackieDo/Timezone-List/graphs/contributors).

# License
[MIT](LICENSE) © Jackie Do