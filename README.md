# Feature
- Render a timezone listbox (select element) in Laravel
- Render a timezone array in Laravel

# Installation

You can install this package through [Composer](https://getcomposer.org).

- First, edit your project's `composer.json` file to require `jackiedo/timezonelist`:

```php
...
"require": {
	...
    "jackiedo/timezonelist": "5.*"
},
```

- Next, update Composer from the Terminal:

```shell
$ composer update
```

- Once update operation completes, the final step is to add the service provider. Open `config/app.php`, and add a new item to the providers array:

```php
...
'providers' => array(
    ...
    Jackiedo\Timezonelist\TimezonelistServiceProvider::class,
),
```

# Usage

###### 1. Render a timezone listbox

To do so, use method `Timezonelist::create($name)`.

Example:
```php
Timezonelist::create('timezone');
```

Method `Timezonelist::create()` have three parameters:
```php
Timezonelist::create($name, $selected, $attr);
```
- The first parameter is required, but the second and third is optional.

- The second parameter use to set selected value of list box.

Example:
```php
Timezonelist::create('timezone', 'Asia/Ho_Chi_Minh');
```

- The third parameter use to set HTML attribute of select tag.

Example:
```php
Timezonelist::create('timezone', null, 'class="styled"');
```

You can also add multiple attribute.

Example:
```php
Timezonelist::create('timezone', null, 'id="timezone" class="styled"');
```

Or you can also add multiple attribute with one array.

Example:
```php
Timezonelist::create('timezone', null, [
    'id'    => 'timezone',
    'class' => 'styled',
    ...
]);
```

###### 2. Render a timezone array

You can also render timezone list as an array. To do so, just use method `Timezonelist::toArray()`.

Example in Laravel:
```php
$timezone_list = Timezonelist::toArray();
```

# Thanks for use
Hopefully, this package is useful to you.