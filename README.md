A Laravel package to earmark sequential values in a series and eliminate any gaps in the series when values are `unset`.  *Allowing for values to be reused.*

For instance, it can be used to fetch the next value (or array of values) to be used in an application.  

An example is reserving the next available phone extension for a user.  The phone extension can be reserved by the active session, preventing other sessions from obtaining the same value.

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

## 3. Recommended

This package is designed to use Laravel Queues, to defer the time consuming task of repopulating available pool of values.

You may want to change the default `QUEUE_CONNECTION` to use another strategy.  But the package does work without the default, it just may cause some latency in your application.

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

## Simple Usage

With the values from the configuration file, use `Earmarked::get()` and `Earmarked::unset()`.

```php
$serial = Earkmarked::get(); // Returns: '2010'
Earkmarked::unset($serial);
```

You can also *specify* the number of values to return in an array:

```php
$serial = Earkmarked::get(3); // Returns: [ '2011', '2012', '2013', ]
Earkmarked::unset($serial);
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

*The new series will not affect the default series, calling the series again will provide the next values.*

```php
$serial = Earkmarked::get(); // Returns: '2014'
$serial = Earkmarked::get(3); // Returns: [ '2015', '2016', '2017', ]
$earmark = new Earmark('ZULU', null, 10, 5000, null);
$earmark->get(); // Returns: 'ZULU0000005004'
$earmark->get(3); // Returns: [ 'ZULU0000005005', 'ZULU0000005006', 'ZULU0000005007', ]
```

## How it works

Searching for gaps in a numerical series of numbers can be resource intensive.  *Depends on the size of the series.*  

This package uses two (`2`) tables, one for the series of used numbers and one to `Hold` a group of available numbers for immediate use.  The package will `get()` the next consecutive number from the `Hold` table.

When the available numbers in the `Hold` falls below one-third, this package will repopulate the `Hold` with more numbers.  *This package works best with Laravel queues.*

## Additional Feature

### Auto-Increment

*Sometimes* you just want the next number in an auto-increment series of numbers.  One is included in this package.  It *does not* support `prefix`, *will not* support `suffix`, but you **can** use zero-padding.

```php
Earmarked::increment(); // Returns: 1
Earmarked::increment(); // Returns: 2
$earmark = new Earmark('ZULU', null, 20, 5000, null);
$earmark->increment(true); // Returns: '00000000000000000003'

```

