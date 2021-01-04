# Usage

## Instantiation

Once installed, you can instantiate the class how you wish:

```php
use Floor9design\TestDataGenerator\Generator;
$generator = new Generator();
```

You may wish to include this as a service/dependency inject it.

## Generating Data

### Integers

Integers can be created as follows:

* `Generator::randomInteger()`

```php
use Floor9design\TestDataGenerator\Generator
$generator = new Generator();

$integer = $generator->randomInteger();
// returns an integer between 1 and 1000 

// Set some bounds up:
$min = 25; 
$max = 50;

$integer_with_bounds = $generator->randomInteger($min, $max);
// returns an integer between 25 and 50 

$integer_with_silly_bounds = $generator->randomInteger($min, $min);
// returns an integer between 25 and 25 inclusive... which is 25

```

In the case where you need an array of integers, such as an array of ID's:

```php
use Floor9design\TestDataGenerator\Generator
$generator = new Generator();

// Set some bounds up:
$min = 25; 
$max = 50;
$array_length = 5;

$integer = $generator->randomIntegerArray($min, $max, $array_length);
// returns an array of 5 integers between 25 and 50
```

