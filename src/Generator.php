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
     * Returns and array of random integer between $min and $max, as per randomInteger
     *
     * @param int|null $min
     * @param int|null $max
     * @param int|null $length
     * @return array
     * @throws GeneratorException
     */
    public function randomIntegerArray(?int $min = 1, ?int $max = 1000, ?int $length = 3): array
    {
        $int_array = [];
        $total = 1;

        try {
            while ($total <= $length) {
                $int_array[] = $this->randomInteger($min, $max);
                $total++;
            }
        } catch (GeneratorException $e) {
            throw new GeneratorException('Generator::randomIntegerArray() threw an Exception: ' . $e->getMessage());
        }
        return $int_array;
    }

}
