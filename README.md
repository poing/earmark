This is a Laravel package to earmark the next sequential value in a series.
It uses Eloquent to store a handful of available values, locking the DB while the value is retreived.  This is to handle concurrency for multi-step oprations.  

For instance fetching the next value to be applied later in a process.  An example is to reserve the next available phone number.  The phone number can be assigned to the active session, prevening concurrent sessions from obtaining the same value.  

# Getting Started

## 1. Install EarMark

Run this at the command line:

```
composer require poing/earmark

```

This will update composer.json and install the package into the vendor/ directory.

## 2. Publish the EarMark Configuration File

To over-ride the default settings, initialise the config file by running this command:

```
php artisan earmark:config
```

Then open config/earmark.php and edit the settings to meet the requirements of your application.



## Consecutive Numbers

Get Rid of Gaps in Numerical Sequences

* 4000
* 4001
* 4003

Depending on the package configuration, 4002 will be offered again.  Allowing for gaps in the number sequence to be eliminated.

```php
Earmarked::get(); // returns: '00004000'
Earmarked::unset('00004000');
Earmarked::get(); // returns: '00004001'
Earmarked::get(); // returns: '00004002'
Earmarked::get(); // returns: '00004000'
Earmarked::get(); // returns: '00004003'
```

### How it works

Searching for gaps in a numerical series of numbers can be resource intensive.  *Depends on the size of the series.*  

This package uses two (`2`) tables, one for the series of used numbers and one to `Hold` a group of available numbers for immediate use.  The package will `get()` the next consecutive number from the `Hold` table.

When the available numbers in the `Hold` falls below one-third, this package will repopulate the `Hold` with more numbers.  *This package works best with Laravel queues.*



## Simple Usage

```php
$serial = Earkmarked::get();  Returns 'PREFIX00000001'
$serial->unset('PREFIX00000001'); 
```


You may also get and unset arrays.
```php
$serial = new Earmark('PREFIX', 5555);
$serial->get(2); Returns ['PREFIX0005555', 'PREFIX00005556', ]

$old = ['PREFIX00005555', 'PREFIX00005556', ]
$serial->unset($old); 
```

