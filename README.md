# Feature
Render a timezone listbox (select box) in Laravel

## Installation

You can install this package through [Composer](https://getcomposer.org).

First, edit your project's `composer.json` file to require `jackiedo/timezonelist`:

```php
	...
    "require": {
		...
        "jackiedo/timezonelist": "dev-master"
	},
```

Next, update Composer from the Terminal:

```shell
$ composer update
```

Once update operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array:

```php
	...
    'providers' => array(
        ...
        'Jackiedo\Timezonelist\TimezonelistServiceProvider',
	),
```

### Usage

- To render a timezone select box, use method Timezonelist::create($select_box_name).

Example:
```php
	Timezonelist::create('timezone');
```

Method Timezonelist::create() have three parameters:
```php
	Timezonelist::create($name, $selected_value, $html_atribute);
```
The first parameter is required, but the second and third is optional.

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
	Timezonelist::create('timezone', null, 'class="styled" placeholder="Please select a timezone"');
```

Or you can also add multiple attribute with one array.

Example:
```php
	Timezonelist::create('timezone', null, array(
        'class' => 'styled',
        'placeholder' => 'Please select a timezone'
    ));
```

Hopefully, this package is useful to you.