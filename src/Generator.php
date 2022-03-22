<?php
/**
 * Generator.php
 *
 * Generator class
 *
 * php 7.3+
 *
 * @category  None
 * @package   Floor9design\TestDataGenerator
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   Private software
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/test-data-generator
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\TestDataGenerator;

/**
 * Class Generator
 *
 * Provides methods for generating test data.
 *
 * @category  None
 * @package   Floor9design\TestDataGenerator
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   Private software
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/test-data-generator
 * @link      https://floor9design.com
 * @since     File available since Release 1.0
 */
class Generator
{
    // Base functions

    /**
     * A random boolean
     *
     * @return bool
     * @throws GeneratorException
     */
    public function randomBoolean(): bool
    {
        // (int) rounds down, make a bool out of (int)0-2
        return (bool)((int)$this->randomInteger(0, 2));
    }

    /**
     * A random float between $min and $max, to $decimal_places accuracy.
     * This is inclusive -> $min and $max are possible outcomes
     *
     * @param float|null $min
     * @param float|null $max
     * @param int|null $decimal_places
     * @return float
     * @throws GeneratorException
     */
    public function randomFloat(?float $min = 5, ?float $max = 1000, ?int $decimal_places = null): float
    {
        if ($min > $max) {
            throw new GeneratorException('The max value must be above the minimum value');
        }

        // convert them to integers (multiply by calculated decimal places eg: 0.2 * 10 = 2):
        $decimal_places_min =  strlen((string)$min) - strrpos((string)$min, '.') - 1;
        $decimal_places_max =  strlen((string)$max) - strrpos((string)$max, '.') - 1;

        if($decimal_places_max >= $decimal_places_min) {
            $calculated_decimal_places = $decimal_places_max;
        } else {
            $calculated_decimal_places = $decimal_places_min;
        }

        $factor = $this->randomInteger();

        // Return random int number
        $calculated_max = (int)($max * $factor * $calculated_decimal_places);
        $calculated_min = (int)($min * $factor * $calculated_decimal_places);

        $value = $this->randomInteger($calculated_min, $calculated_max) / ($factor * $calculated_decimal_places);

        if ($decimal_places) {
            $value = round($value, $decimal_places);
        }

        return (float)$value;
    }

    /**
     * A random integer between $min and $max
     * This is inclusive -> $min and $max are possible outcomes
     *
     * @param int|null $min
     * @param int|null $max
     * @return int
     * @throws GeneratorException
     */
    public function randomInteger(?int $min = 1, ?int $max = 1000): int
    {
        if ($min > $max) {
            throw new GeneratorException('The max value must be above the minimum value');
        }

        return mt_rand((int)$min, (int)$max);
    }

    /**
     * Returns an array of random integers between $min and $max, as per randomInteger
     *
     * @param int|null $min
     * @param int|null $max
     * @param int|null $array_length
     * @return array<int>
     * @throws GeneratorException
     * @see randomInteger()
     */
    public function randomIntegerArray(?int $min = 1, ?int $max = 1000, ?int $array_length = 3): array
    {
        $int_array = [];
        $total = 1;

        try {
            while ($total <= $array_length) {
                $int_array[] = $this->randomInteger($min, $max);
                $total++;
            }
        } catch (GeneratorException $e) {
            throw new GeneratorException('Generator::randomIntegerArray() threw an Exception: ' . $e->getMessage());
        }
        return $int_array;
    }

    /**
     * Returns a json string of a with the specified number of types
     *
     * @param int|null $number_of_arrays
     * @param int|null $number_of_booleans
     * @param int|null $number_of_floats
     * @param int|null $number_of_integers
     * @param int|null $number_of_strings
     * @return string
     * @throws GeneratorException
     * @see randomString()
     */
    public function randomJson(
        ?int $number_of_arrays = 3,
        ?int $number_of_booleans = 3,
        ?int $number_of_floats = 3,
        ?int $number_of_integers = 3,
        ?int $number_of_strings = 3
    ): string
    {
        $json_array = [];

        $total = 1;
        while ($total <= $number_of_arrays) {
            $json_array['arrays' . $total] = $this->randomStringArray();
            $total++;
        }

        $total = 1;
        while ($total <= $number_of_booleans) {
            $json_array['booleans' . $total] = $this->randomBoolean();
            $total++;
        }

        $total = 1;
        while ($total <= $number_of_floats) {
            $json_array['floats' . $total] = $this->randomFloat();
            $total++;
        }

        $total = 1;
        while ($total <= $number_of_integers) {
            $json_array['integers' . $total] = $this->randomInteger();
            $total++;
        }

        $total = 1;
        while ($total <= $number_of_strings) {
            $json_array['strings' . $total] = $this->randomString();
            $total++;
        }

        // shuffle items to arrange in a more "real" way
        shuffle($json_array);

        return (string)json_encode($json_array);
    }

    /**
     * Returns a random MySQL Date : Y-m-d
     *
     * @param string|null $format
     * @return string
     * @throws GeneratorException
     */
    public function randomMySqlDate(?string $format = 'Y-m-d'): string
    {
        return date((string)$format, $this->randomMySqlDateTimeTimestamp());
    }

    /**
     * Returns a timestamp inside MySQL's date/datetime range
     *
     * The supported range is from '1000-01-01' to '9999-12-31':
     * In timestamps: -30610223999, 253402300799
     *
     * @return int
     * @throws GeneratorException
     */
    public function randomMySqlDateTimeTimestamp(): int
    {
        return $this->randomInteger(-30610223999, 253402300799);
    }

    /**
     * Returns a random string
     *
     * @param int|null $length
     * @return string
     */
    public function randomString(?int $length = 10): string
    {
        $output = '';

        while (strlen($output) < $length) {
            $output .= md5((string)rand());
        }

        // trim it back down to the correct length:
        return substr($output, 0, $length);
    }

    /**
     * Returns an array of strings, as per randomString
     *
     * @param int|null $length
     * @param int|null $array_length
     * @return array<string>
     * @see randomString()
     */
    public function randomStringArray(?int $length = 5, ?int $array_length = 5): array
    {
        $string_array = [];
        $total = 1;

        while ($total <= $array_length) {
            $string_array[] = $this->randomString($length);
            $total++;
        }

        return $string_array;
    }

    // Shortcut/aliases

    /**
     * A random float between $min and $max, to 2 decimal places accuracy, with defaults to match a normal currency
     * amount.
     * This is inclusive -> $min and $max are possible outcomes
     *
     * @param float|null $min
     * @param float|null $max
     * @param int|null $decimal_places
     * @return float
     * @throws GeneratorException
     */
    public function randomCurrency(?float $min = 5, ?float $max = 1000, ?int $decimal_places = 2): float
    {
        return $this->randomFloat($min, $max, $decimal_places);
    }

    /**
     * A random string that looks like an image src.
     *
     * @param string|null $suffix
     * @param int|null $length length of the string before the suffix
     * @return string
     */
    public function randomImageSrc(?string $suffix = '.png', ?int $length = 8): string
    {
        $response = $this->randomString($length) . $suffix;

        // lower case to resemble a websafe src
        return strtolower($response);
    }

    /**
     * A random string that looks like an image url.
     *
     * @param string|null $image_src_suffix
     * @param int|null $image_src_length
     * @param string|null $url_suffix
     * @param int|null $url_length
     * @param bool|null $protocol
     * @return string
     */
    public function randomImageUrl(
        ?string $image_src_suffix = '.png',
        ?int $image_src_length = 8,
        ?string $url_suffix = '.com',
        ?int $url_length = 12,
        ?bool $protocol = true
    ): string {
        $response = $this->randomUrl($url_suffix, $url_length, $protocol);
        $response .= '/';
        $response .= $this->randomImageSrc($image_src_suffix, $image_src_length);

        return $response;
    }

    /**
     * Returns a MySQLDateTime string : Y-m-d H:i:s
     *
     * @param string|null $format
     * @return string
     * @throws GeneratorException
     */
    public function randomMySqlDateTime(?string $format = 'Y-m-d H:i:s'): string
    {
        return date((string)$format, $this->randomMySqlDateTimeTimestamp());
    }

    /**
     * A random string that looks like a website url.
     *
     * @param string|null $suffix of the generated domain
     * @param int|null $length length of the string before the suffix
     * @param bool|null $protocol
     * @return string
     */
    public function randomUrl(?string $suffix = '.com', ?int $length = 12, ?bool $protocol = true): string
    {
        $response = '';

        if($protocol) {
            $response .= 'http://';
        }
        $response .= $this->randomString($length) . $suffix;

        // lower case to resemble a url
        return strtolower($response);
    }

    /**
     * A random string that looks like an email.
     *
     * @param string|null $suffix of the generated domain
     * @param int|null $prefix_length length of the string before the @
     * @param int|null $domain_length length of the string before the suffix
     * @return string
     */
    public function randomEmail(?string $suffix = '.com', ?int $prefix_length = 6, ?int $domain_length = 12): string
    {
        $response = '';

        $response .= $this->randomString($prefix_length) . '@' . $this->randomString($domain_length) . $suffix;

        // lower case to resemble an email
        return strtolower($response);
    }

    /**
     * A random string that might be appropriate for passwords
     *
     * Mixed chars, mixed case, symbols and a length of 16 creates a password that (at the time of writing)
     * takes at least four hundred billion years to bruteforce.
     *
     * @param int $length minimum size of 11 in order for bruteforce to be longer than a human lifespan
     * @return string
     * @throws GeneratorException
     */
    public function randomPassword(
        int $length = 16
    ) : string
    {
        if($length < 11) {
            throw new GeneratorException('Passwords must be 11 characters long for them to be secure');
        }

        // have to be a little more thoroughly than $this->randomString()

        $password = [];

        $lower_case_characters = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase_case_characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $number_characters = '0123456789';
        $symbol_characters = '!"#$%&()*+,-./:;<=>?@[\]^_`{|}~';

        $charsets = [$lower_case_characters, $uppercase_case_characters, $number_characters, $symbol_characters];

        // guaranteed chars:
        foreach($charsets as $charset) {
            $char_added = false;
            while($char_added == false) {
                $random_key = $this->randomInteger(0, $length-1);
                if(!isset($password[$random_key])) {
                    $char_index = $this->randomInteger(0, strlen($charset));
                    $password[$random_key] = substr($charset, $char_index, 1);
                    $char_added = true;
                }
            }
        }

        // now fill up with random chars:
        $key = 0;
        while($key < $length) {
            $charset = $charsets[$this->randomInteger(0, 3)];
            if(!isset($password[$key])) {
                $char_index = $this->randomInteger(0, strlen($charset));
                $password[$key] = substr($charset, $char_index, 1);
            }
            $key++;
        }

        return implode($password);
    }

}
