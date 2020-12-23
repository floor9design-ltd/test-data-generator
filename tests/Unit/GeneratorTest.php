<?php
/**
 * GeneratorTest.php
 *
 * GeneratorTest class
 *
 * php 7.3+
 *
 * @category  None
 * @package   Floor9design\Eventim\PluginCore\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/test-data-generator
 * @link      https://floor9design.com
 * @version   1.0
 * @since     File available since Release 1.0
 *
 */

namespace Floor9design\TestDataGenerator\Tests\Unit;

use Floor9design\TestDataGenerator\Generator;
use PHPUnit\Framework\TestCase;

/**
 * GeneratorTest
 *
 * Tests the Generator
 *
 * @category  None
 * @package   Floor9design\Eventim\PluginCore\Tests\Unit
 * @author    Rick Morice <rick@floor9design.com>
 * @copyright Floor9design Ltd
 * @license   MIT
 * @version   1.0
 * @link      https://github.com/floor9design-ltd/test-data-generator
 * @link      https://floor9design.com
 * @version   1.0
 * @see       \Floor9design\TestDataGenerator\Generator
 * @since     File available since Release 1.0
 */
class GeneratorTest extends TestCase
{
    public function testTests()
    {
        $generator = new Generator();
        $this->assertTrue(true);
    }
}

