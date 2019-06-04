This is a Laravel package to ermark the next sequential value in a series.
It uses Eloquent to store a handful of available values, locking the DB while the value is retreived.  This is to handle concurrency for multi-step oprations.  

For instance fetching the next value to be applied later in a process.  An example is to reserve the next available phone number.  The phone number can be assigned to the active session, prevening concurrent sessions from obtaining the same value.  




## Consecutive Numbers

Get Rid of Gaps in Numerical Sequences

* 2000
* 2001
* 2003

Depending on the package configuration, the next number provided would be 2002.

eliminate gaps

```php
$earmark = new Poing\Earmark\Http\Controllers\Serial();
$earmark->get();  // returns: 2002
$earmark->release(2002);
```

### How it works

Searching for gaps in a numerical series of numbers can be resource intensive.  *Depends on the size of the series.*  

This package uses two (`2`) tables, one for the series of used numbers and one to `Hold` a group of available numbers for immediate use.  The package will `get()` the next consecutive number from the `Hold` table.

When the available numbers in the `Hold` falls below one-third, this package will repopulate the `Hold` with more numbers.  *This package works best with Laravel queues.*



## Simple Usage

```
$serial = Earkmarked::get();  Returns 'PREFIX00000001'
$serial->unset('PREFIX00000001'); 
```


You may also get and unset arrays.
```
$serial = new Earmark('PREFIX', 5555);
$serial->get(2); Returns ['PREFIX0005555', 'PREFIX00005556', ]

$old = ['PREFIX00005555', 'PREFIX00005556', ]
$serial->unset($old); 
```

