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
    // Core functions

    /**
     * Tests Generator::randomBoolean()
     *
     * @see Generator
     * @throws GeneratorException
     */
    public function testRandomBoolean()
    {
        $generator = new Generator();

        $this->assertIsBool($generator->randomBoolean());
    }

    /**
     * Tests Generator::randomFloat()
     *
     * @see Generator
     * @throws GeneratorException
     */
    public function testRandomFloat()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomFloat();
        $this->assertIsFloat($output);

        // bounds
        $output = $generator->randomFloat(50, 100);
        $this->assertIsFloat($output);

        // above the bottom bound
        $this->assertTrue($output > 49);

        // below the top bound
        $this->assertTrue($output < 101);

        // edge case
        $output = $generator->randomFloat(50, 50);
        $this->assertEquals(50, $output);

        // decimal places
        $expected_decimal_places = 2;
        $output = $generator->randomFloat(50, 100, $expected_decimal_places);

        if ((int)$output == $output) {
            $decimal_places = 0;
        } else {
            $decimal_places = strlen($output) - strrpos($output, '.') - 1;
        }
        $this->assertTrue($decimal_places <= $expected_decimal_places);

        // Exception
        $this->expectException(GeneratorException::class);
        $generator->randomFloat(100, 50);
    }

    /**
     * Tests Generator::randomInteger()
     *
     * @see Generator
     * @throws GeneratorException
     */
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
        $this->assertTrue($output > 49);

        // below the top bound
        $this->assertTrue($output < 101);

        // edge case
        $output = $generator->randomInteger(50, 50);
        $this->assertEquals(50, $output);

        // exception
        $this->expectException(GeneratorException::class);
        $generator->randomInteger(100, 50);
    }

    /**
     * Tests Generator::randomIntegerArray()
     *
     * @see Generator
     * @throws GeneratorException
     */
    public function testRandomIntegerArray()
    {
        $generator = new Generator();

        // test structure
        $output = $generator->randomIntegerArray();
        $this->assertIsArray($output);

        foreach ($output as $should_be_int) {
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

    /**
     * Tests Generator::randomMySqlDate()
     *
     * @see Generator
     * @throws GeneratorException
     */
    public function testRandomMySqlDate()
    {
        $generator = new Generator();

        // test it is a valid time:
        $this->assertIsInt(strtotime($generator->randomMySqlDate()));
    }

    /**
     * Tests Generator::randomMySqlDateTimeTimestamp()
     *
     * @see Generator
     * @throws GeneratorException
     */
    public function testRandomMySqlDateTimeTimestamp()
    {
        $generator = new Generator();

        $output = $generator->randomMySqlDateTimeTimestamp();

        // test it is a valid time:
        $this->assertIsInt($output);

        // above the bottom MySql bound
        $this->assertTrue($output >= -30610223999);

        // below the top MySql bound
        $this->assertTrue($output <= 253402300799);

    }

    /**
     * Tests Generator::randomString()
     * @see Generator
     */
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

    /**
     * Tests Generator::randomStringArray()
     * @see Generator
     */
    public function testRandomStringArray()
    {
        $generator = new Generator();

        // test for strings
        $output = $generator->randomStringArray();
        $this->assertIsArray($output);

        foreach ($output as $should_be_string) {
            $this->assertIsString($should_be_string);
        }

        // test size
        $output = $generator->randomStringArray(5, 10);
        $this->assertEquals(10, count($output));

        // test empty
        $output = $generator->randomStringArray(5, 0);
        $this->assertEquals(0, count($output));
    }

    // Aliases

    /**
     * Tests Generator::randomCurrency()
     *
     * @see Generator
     * @throws GeneratorException
     */
    public function testRandomCurrency()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomCurrency();
        $this->assertIsFloat($output);

        // above the bottom default bound
        $this->assertTrue($output > 4);

        // below the top bound
        $this->assertTrue($output < 1001);

        // decimal places
        $expected_decimal_places = 2;

        if ((int)$output == $output) {
            $decimal_places = 0;
        } else {
            $decimal_places = strlen($output) - strrpos($output, '.') - 1;
        }
        $this->assertTrue($decimal_places <= $expected_decimal_places);

        // Exception
        $this->expectException(GeneratorException::class);
        $generator->randomCurrency(100, 50);
    }

    /**
     * Tests Generator::randomImageSrc()
     *
     * @see Generator
     */
    public function testRandomImageSrc()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomImageSrc();
        $this->assertIsString($output);

        // check length
        $this->assertEquals(12, strlen($output));

        // check suffix
        $this->assertEquals('.png', substr($output, -4));

        // bounds and changes
        $output = $generator->randomImageSrc('.jpg', 7);

        // check length
        $this->assertEquals(11, strlen($output));

        // check suffix
        $this->assertEquals('.jpg', substr($output, -4));

    }

    /**
     * Tests Generator::randomImageUrl()
     *
     * @see Generator
     */
    public function testRandomImageUrl()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomImageUrl();
        $this->assertIsString($output);

        // check length
        $this->assertEquals(29, strlen($output));

        // check suffix
        $this->assertEquals('.png', substr($output, -4));

        // bounds and changes
        $output = $generator->randomImageSrc('.jpg', 7);

        // check length
        $this->assertEquals(11, strlen($output));

        // check suffix
        $this->assertEquals('.jpg', substr($output, -4));

    }

    /**
     * Tests Generator::randomMySqlDateTime()
     *
     * @throws GeneratorException
     */
    public function testRandomMySqlDateTime()
    {
        $generator = new Generator();

        // test it is a valid time:
        $this->assertIsInt(strtotime($generator->randomMySqlDateTime()));
    }

    /**
     * Tests Generator::randomUrl()
     *
     * @see Generator
     */
    public function testRandomUrl()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomUrl();
        $this->assertIsString($output);

        // check length
        $this->assertEquals(16, strlen($output));

        // check suffix
        $this->assertEquals('.com', substr($output, -4));

        // bounds and changes
        $output = $generator->randomImageSrc('.org', 7);

        // check length
        $this->assertEquals(11, strlen($output));

        // check suffix
        $this->assertEquals('.org', substr($output, -4));

    }

}

