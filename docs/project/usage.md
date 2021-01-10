# Usage

## Instantiation

Once installed, you can instantiate the class how you wish:

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();
```

You may wish to include this as a service/dependency inject it.

## Generating Data

### Booleans

Booleans can be created as follows:

* `Generator::randomBoolean()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

$boolean = $generator->randomBoolean();
// returns a boolean. e.g: true 
```

### Dates/Times

There are a number of date/time functions. These are based on the MySql format, and thus there are limits.

To generate a MySql compatible timestamp:

* `Generator::randomMySqlDateTimeTimestamp()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

$float = $generator->randomMySqlDateTimeTimestamp();
// returns a timestamp between '1000-01-01' to '9999-12-31', which is: -30610223999 to 253402300799
```

This is the engine for the other functions, so these bounds apply to all following functions.

Dates can be created as follows:

* `Generator::randomMySqlDate()`
* `Generator::randomMySqlDateTime()` (a quick alias of the above)

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

// Standard formats:
$date = $generator->randomMySqlDate();
// returns a date in the form: Y-m-d. e.g: 1384-12-28
$date_time = $generator->randomMySqlDateTime(); 
// returns a date in the form: Y-m-d H:i:s. e.g: 1384-12-28 12:36:23

// Return a custom string:
$float = $generator->randomMySqlDate('l jS \of F Y h:i:s A');
// returns a custom formatted date: e.g Monday 8th of August 2005 03:12:46 PM
```

### Floats

Floats can be created as follows:

* `Generator::randomFloat()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

$float = $generator->randomFloat();
// returns a float between 1 and 1000 to 2 decimal places. e.g: 834.23 

// Set some bounds up:
$min = 25; 
$max = 50;
$decimal_places = 3;

$float_with_bounds = $generator->randomFloat($min, $max, $decimal_places);
// returns a float between 25 and 50. e.g: 37.821

$float_with_silly_bounds = $generator->randomFloat($min, $min);
// returns a float between 25 and 25 inclusive, which is guaranteed to be: 25

```

### Integers

Integers can be created as follows:

* `Generator::randomInteger()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

$integer = $generator->randomInteger();
// returns an integer between 1 and 1000. e.g: 722 

// Set some bounds up:
$min = 25; 
$max = 50;

$integer_with_bounds = $generator->randomInteger($min, $max);
// returns an integer between 25 and 50. e.g: 34

$integer_with_silly_bounds = $generator->randomInteger($min, $min);
// returns an integer between 25 and 25 inclusive, which is guaranteed to be: 25

```

In the case where you need an array of integers, such as an array of ID's:

* `Generator::randomIntegerArray()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

// Set some bounds up:
$min = 25; 
$max = 50;
$array_length = 5;

$array_of_integers = $generator->randomIntegerArray($min, $max, $array_length);
// returns an array of 5 integers between 25 and 50. e.g: [34, 28, 44, 41, 29]
```

### Strings

Strings can be created as follows:

* `Generator::randomString()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

$string = $generator->randomString();
// returns a string of length 10. e.g: abDFxcHdso 

// Set length:
$length = 5; 

$string_with_bounds = $generator->randomString($length);
// returns a string of length 10. e.g: hDezs
```

In the case where you need an array of strings:

* `Generator::randomStringArray()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

// Set some bounds up:
$length = 5; 
$array_length = 3;

$array_of_strings = $generator->randomStringArray($length, $array_length);
// returns an array of 3 strings of length 5. e.g: [HyDST, aKjhD, ojkla]
```

There are also some preformatted/special string aliases:

* `Generator::randomUrl()`
* `Generator::randomImageSrc()`
* `Generator::randomImageUrl()`

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

// Create a url:
$random_url = $generator->randomUrl();
// returns a random url style string: http://frdtbshsld.com

// create a configured url
$random_url_configured = $generator->randomUrl('.org', 6, false);
// returns a random url style string with .org suffix, 6 character long domain and no protocol: bshsld.org

// Create an image src:
$random_src = $generator->randomImageSrc();
// returns a random src style string: aefrstde.png


// Create a configured image src:
$random_src = $generator->randomImageSrc('.jpg', 3);
// returns a random src style string: tde.jpg

// Create an image url:
$random_src = $generator->randomImageUrl();
// returns a random src style string: http://frdtbshsld.com/aefrstde.png

// create a configured url
$random_url_configured = $generator->randomImageUrl('.jpg', 5, '.org', 6, false);
// returns a random url style string with:
// .jpg image suffix, 5 chars long
// a domain with a .org suffix, 6 character long domain and no protocol
// bshsld.org/frdst.jpg
```

### Json

Json can be created as follows:

* `Generator::randomJson()`

This function creates a json string with a combination of different json elements:

* arrays
* booleans 
* floats
* integers
* strings

Note that the return order has `shuffle()` applied to it, so they are in a more random
order.

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();

$json = $generator->randomJson();
// returns a json object with 3 of each element types 

$json_arrays_only = $generator->randomJson(5, 0, 0, 0, 0);
// returns a json object with only 5 arrays
```