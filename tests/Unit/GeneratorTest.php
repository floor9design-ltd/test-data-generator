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
        $this->assertIsFloat($output);

        // decimal places
        $expected_decimal_places = 2;
        $output = $generator->randomFloat(50, 100, $expected_decimal_places);

        if ((int)$output == $output) {
            $decimal_places = 0;
        } else {
            $decimal_places = strlen($output) - strrpos($output, '.') - 1;
        }
        $this->assertTrue($decimal_places <= $expected_decimal_places);

        // decimal places alternate route
        $expected_decimal_places = 2;
        $output = $generator->randomFloat(50.02, 100.1, $expected_decimal_places);

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
     * Tests Generator::randomJson()
     *
     * @see Generator
     * @throws GeneratorException
     */
    public function testRandomJson()
    {
        $generator = new Generator();

        // test arrays
        $output = $generator->randomJson(5, 0, 0, 0, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(5, $json_decoded);

        foreach ($json_decoded as $should_be_array) {
            $this->assertIsArray($should_be_array);
        }

        // test booleans
        $output = $generator->randomJson(0, 5, 0, 0, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(5, $json_decoded);

        foreach ($json_decoded as $should_be_boolean) {
            $this->assertIsBool($should_be_boolean);
        }

        // test floats
        $output = $generator->randomJson(0, 0, 5, 0, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(5, $json_decoded);

        foreach ($json_decoded as $should_be_float) {
            // as it's gone through the process of being made into json cast info is lost, so 50 float is now 50 int:
            $cast_float = (float)$should_be_float;
            $this->assertIsFloat($cast_float);
            // check that they're equivalent
            $this->assertEquals($cast_float, $should_be_float);
        }

        // test integers
        $output = $generator->randomJson(0, 0, 0, 5, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(5, $json_decoded);

        foreach ($json_decoded as $should_be_integer) {
            $this->assertIsInt($should_be_integer);
        }

        // test strings
        $output = $generator->randomJson(0, 0, 0, 0, 5);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(5, $json_decoded);

        foreach ($json_decoded as $should_be_string) {
            $this->assertIsString($should_be_string);
        }

        // Mixed tests
        $output = $generator->randomJson();
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(15, $json_decoded);


        // test full
        $output = $generator->randomJson(5, 5, 5, 5, 5);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(25, $json_decoded);

        // test empty
        $output = $generator->randomJson(0, 0, 0, 0, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(0, $json_decoded);

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
        var_dump($output);
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
        $this->assertEquals(36, strlen($output));

        // check suffix
        $this->assertEquals('.png', substr($output, -4));

        // bounds and changes
        $output = $generator->randomImageUrl('.jpg', 7, '.com', 4, false);

        // check length
        $this->assertEquals(20, strlen($output));

        // check suffix
        $this->assertEquals('.jpg', substr($output, -4));

        // check lowercase
        $this->assertFalse(preg_match("/[A-Z0-9]/", $output)===0);
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
        $this->assertEquals(23, strlen($output));

        // check suffix
        $this->assertEquals('.com', substr($output, -4));

        // check prefix
        $this->assertEquals('http://', substr($output, 0, 7));

        // bounds and changes
        $output = $generator->randomUrl('.org', 7, false);

        // check length
        $this->assertEquals(11, strlen($output));

        // check suffix
        $this->assertEquals('.org', substr($output, -4));

        // check lowercase
        $this->assertFalse(preg_match("/[A-Z0-9]/", $output)===0);

    }

    /**
     * Tests Generator::randomEmail()
     *
     * @see Generator
     */
    public function testRandomEmail()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomEmail();
        $this->assertIsString($output);

        // check length
        $this->assertEquals(23, strlen($output));

        // check suffix
        $this->assertEquals('.com', substr($output, -4));

        // check includes @
        $this->assertStringContainsString('@', $output);

        // bounds and changes
        $output = $generator->randomEmail('.org', 5, 5);

        // check length
        $this->assertEquals(15, strlen($output));

        // check suffix
        $this->assertEquals('.org', substr($output, -4));

        // check lowercase
        $this->assertFalse(preg_match("/[A-Z0-9]/", $output)===0);

    }

}

