<?php
/**
 * GeneratorTest.php
 *
 * GeneratorTest class
 *
 * php 7.3+
 *
 * @category  None
 * @package   Floor9design\TestDataGenerator\Tests\Unit
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
use Floor9design\TestDataGenerator\GeneratorException;
use PHPUnit\Framework\TestCase;


/**
 * GeneratorTest
 *
 * Tests the Generator
 *
 * @category  None
 * @package   Floor9design\TestDataGenerator\Tests\Unit
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
    public function testRandomInteger()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomInteger();
        $this->assertIsInt($output);

        // bounds
        $output = $generator->randomInteger(50, 100);
        $this->assertIsInt($output);

        // above the bottom bound
        $this->assertTrue($output>49);

        // below the top bound
        $this->assertTrue($output<101);

        // edge case
        $output = $generator->randomInteger(50, 50);
        $this->assertEquals(50, $output);

        $this->expectException(GeneratorException::class);
        $generator->randomInteger(100, 50);
    }

    public function testRandomIntegerArray()
    {
        $generator = new Generator();

        // test structure
        $output = $generator->randomIntegerArray();
        $this->assertIsArray($output);

        foreach($output as $should_be_int) {
            $this->assertIsInt($should_be_int);
        }

        // test size
        $output = $generator->randomIntegerArray(50, 100, 5);
        $this->assertEquals(5, count($output));

        // test size
        $output = $generator->randomIntegerArray(50, 100, 0);
        $this->assertEquals(0, count($output));

        // test exception
        $this->expectException(GeneratorException::class);
        $generator->randomIntegerArray(100, 50, 3);

    }

    public function testRandomString()
    {
        $generator = new Generator();

        // test for string
        $this->assertIsString($generator->randomString());

        // test length
        $length = 5;
        $string = $generator->randomString($length);
        $this->assertSame($length, strlen($string));

        // test 0
        $length = 0;
        $string = $generator->randomString($length);
        $this->assertSame($length, strlen($string));

        // test long length
        $length = 25;
        $string = $generator->randomString($length);
        $this->assertSame($length, strlen($string));
    }

    public function testRandomStringArray()
    {
        $generator = new Generator();

        // test for strings
        $output = $generator->randomStringArray();
        $this->assertIsArray($output);

        foreach($output as $should_be_string) {
            $this->assertIsString($should_be_string);
        }

        // test size
        $output = $generator->randomStringArray(5, 10);
        $this->assertEquals(5, count($output));

        // test empty
        $output = $generator->randomStringArray(0, 10);
        $this->assertEquals(0, count($output));
    }
}

