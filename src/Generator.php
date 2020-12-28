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

    /**
     * A random integer between $min and $max
     * This is inclusive -> $min and $max are possible outcomes
     *
     * @param int|null $min
     * @param int|null $max
     * @return int
     * @throws GeneratorException
     */
    public function randomInteger(?int $min = 1, ?int $max = 1000): ?int
    {
        if ($min > $max) {
            throw new GeneratorException('The max value must be above the minimum value');
        }

        return rand($min, $max);
    }

    /**
     * Returns an array of random integers between $min and $max, as per randomInteger
     *
     * @param int|null $min
     * @param int|null $max
     * @param int|null $array_length
     * @return array
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
     * Returns a random string
     *
     * @param int|null $length
     * @return string
     */
    public function randomString(?int $length = 10): string
    {
        $output = '';

        while(strlen($output) < $length) {
            $output .= md5(rand());
        }

        // trim it back down to the correct length:
        return substr($output,0,$length);
    }

    /**
     * Returns an array of strings, as per randomString
     *
     * @param int|null $length
     * @param int|null $array_length
     * @return array
     * @see randomString()
     */
    public function randomStringArray(?int $length = 5, ?int $array_length = 5): array
    {
        $string_array = [];
        $total = 1;

        while ($total <= $length) {
            $string_array[] = $this->randomString($length);
            $total++;
        }

        return $string_array;
    }

}
