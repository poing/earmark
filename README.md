[![Build Status](https://travis-ci.org/poing/earmark.svg?branch=0.1.4)](https://travis-ci.org/poing/earmark)
[![StyleCI](https://github.styleci.io/repos/190128345/shield?branch=0.1.4&style=flat)](https://github.styleci.io/repos/190128345)
[![Coverage Status](https://coveralls.io/repos/github/poing/earmark/badge.svg?branch=0.1.4)](https://coveralls.io/github/poing/earmark?branch=0.1.4)

# Earmark

A Laravel package to earmark sequential values in a series and eliminate any gaps in the series when values are `unset`.  *Allowing for values to be reused.*

It can be used to fetch the next value (or array of values) to be used in an application.  Database locking is used to *prevent* duplicate values from being returned.

# An example...

Reserving the next available phone extension for a user.  The phone extension can be reserved by the active session, preventing other sessions from obtaining the same value.  

When a user leaves the phone extension can be *recycled*, the value can be `unset()`.  Making the value available again for a *future* request.

# Getting Started

## 1. Install EarMark

Run this at the command line:

```
composer require poing/earmark
```

This will update composer.json and install the package into the vendor/ directory.

## 2. Publish the EarMark Configuration File

To over-ride the default settings, initialize the config file by running this command:

```
php artisan earmark:config
```

Then open config/earmark.php and edit the settings to meet the requirements of your application.

## 3. Run the Migrations

Run the package migration files at the command line:

```
php artisan migrate
```

## 4. Recommended

This package is designed to use Laravel Queues, to defer the time consuming task of repopulating the available pool of values.

You may want to change the default `QUEUE_CONNECTION` to use another strategy.  But the package *also* works with the default `sync`, but **may** cause latency in your application.

# Settings

## Hold Size

This is the number of series values that are kept in an available pool.  Once the pool drops below a certain level, more values are added to the pool.  *This is where unused values are recycled.*

## Number Range

This package *currently* supports a minimal value.  `range.min` will define the starting value of the series.  *Default: 2000*

```
2000
2001
2002
2003
```

*`range.max` may be used in the future.*

## Zero Padding

Allows the output value to be zero-padded, depending on the needs of the application.

```
2004
002005
00000000002006
```

## Prefix & Suffix

Appends a *prefix* to the output value.

```
ALPHA2007
ALPHA002008
ALPHA00000000002009
```

*`suffix` may be used in the future.*


# How to Use

There are two ways to use this package:

* `Earmarked` to use the *default* values in the pool.
* `Earmark` to create a **new** pool of values to use.

Available Functions:

* `get()`
  * Returns a *single* formated value.
  * Will accept *option* integer to return an array of formatted values.
* `unset($value)`
  * Accepts *formated* values as a string or array.

## Simple Usage

With the values from the configuration file, use `Earmarked::get()` and `Earmarked::unset()`.

```php
$serial = Earmarked::get(); // Returns: '2010'
Earmarked::unset($serial);
```

You can also *specify* the number of values to return in an array:

```php
$serial = Earmarked::get(3); // Returns: [ '2011', '2012', '2013', ]
Earmarked::unset($serial);
```

## Advanced Usage

You can *initialize* a new series using `Earmark()` and supplying the following variables:

* prefix
* suffix *(non-functional placeholder)*
* padding
* min
* max *(non-functional placeholder)*

```php
// Earmark(prefix, suffix, padding, min, max)
$earmark = new Earmark('ZULU', null, 10, 5000, null);
$earmark->get(); // Returns: 'ZULU0000005000'
$earmark->get(3); // Returns: [ 'ZULU0000005001', 'ZULU0000005002', 'ZULU0000005003', ]
```

*The new series will not affect the default series, calling the series again **(with the same parameters)** will continue the numeric series.*

```php
// Default Series
$serial = Earmarked::get(); // Returns: '2014'
$serial = Earmarked::get(3); // Returns: [ '2015', '2016', '2017', ]

// Using Same Parameters Again
$earmark = new Earmark('ZULU', null, 10, 5000, null);
$earmark->get(); // Returns: 'ZULU0000005004'
$earmark->get(3); // Returns: [ 'ZULU0000005005', 'ZULU0000005006', 'ZULU0000005007', ]
```

## How it works

Searching for gaps in a numerical series of numbers can be resource intensive.  *Depends on the size of the series.*  

This package uses two (`2`) tables, one for the series of used numbers and one to `Hold` a group of available numbers for immediate use.  The package will `get()` the next consecutive number from the `Hold` table.

When the available numbers in the `Hold` table falls below one-third, this package will repopulate the `Hold` with more numbers.  *This package works best with Laravel queues.*

Numbers in a series that have been `unset()` will be added to the `Hold` table for *reuse* when updated.  *Numbers in the `Hold` table **are not** sorted, `unset()` numbers will **eventually** be available again.*  

## Additional Feature

### Auto-Increment

*Sometimes* you just want the next number in an auto-increment series.  One is included in this package.  It *does not* support `prefix`, *will not* support `suffix`, but you **can** use zero-padding.

**Do not use `unset()` with `increment()` values!  You have been warned!**

```php
Earmarked::increment(); // Returns: 1
Earmarked::increment(); // Returns: 2
$earmark = new Earmark('ZULU', null, 20, 5000, null);
$earmark->increment(true); // Returns: '00000000000000000003'

```

## Contributing

Thinking of contributing? 

1. Fork & clone the project: `git clone git@github.com:your-username/earmark.git`.
2. Run the tests and make sure that they pass with your setup: `phpunit`.
3. Create your bugfix/feature branch and code away your changes. Add tests for your changes.
4. Make sure all the tests still pass: `phpunit`.
5. Push to your fork and submit new a pull request.
