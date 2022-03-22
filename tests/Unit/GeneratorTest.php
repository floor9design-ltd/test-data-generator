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
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomBoolean()
    {
        $generator = new Generator();
        $output = $generator->randomBoolean();

        $this->assertIsBool($output, 'randomBoolean did not generate a boolean value : ' . $output);
    }

    /**
     * Tests Generator::randomFloat()
     *
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomFloat()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomFloat();
        $this->assertIsFloat($output, 'randomFloat did not generate a float value : ' . $output);

        // bounds
        $output = $generator->randomFloat(50, 100);
        $this->assertIsFloat($output, 'randomFloat did not generate a float value : ' . $output);

        // above the bottom bound
        $this->assertTrue($output > 49, 'randomFloat did not match the bounds : ' . $output);

        // below the top bound
        $this->assertTrue($output < 101, 'randomFloat did not match the bounds : ' . $output);

        // edge case
        $output = $generator->randomFloat(50, 50);
        $this->assertIsFloat($output, 'randomFloat did not match the bounds : ' . $output);

        // decimal places
        $expected_decimal_places = 2;
        $output = $generator->randomFloat(50, 100, $expected_decimal_places);

        if ((int)$output == $output) {
            $decimal_places = 0;
        } else {
            $decimal_places = strlen($output) - strrpos($output, '.') - 1;
        }
        $this->assertTrue(
            $decimal_places <= $expected_decimal_places,
            'randomFloat did not generate the correct decimal places: ' . $decimal_places . ', ' . $expected_decimal_places
        );

        // decimal places alternate route
        $expected_decimal_places = 2;
        $output = $generator->randomFloat(50.02, 100.1, $expected_decimal_places);

        if ((int)$output == $output) {
            $decimal_places = 0;
        } else {
            $decimal_places = strlen($output) - strrpos($output, '.') - 1;
        }
        $this->assertTrue(
            $decimal_places <= $expected_decimal_places,
            'randomFloat did not generate the correct decimal places: ' . $decimal_places . ', ' . $expected_decimal_places
        );

        // Exception
        $this->expectException(GeneratorException::class);
        $generator->randomFloat(100, 50);
    }

    /**
     * Tests Generator::randomInteger()
     *
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomInteger()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomInteger();
        $this->assertIsInt($output, 'randomInteger did not generate an integer value : ' . $output);

        // bounds
        $output = $generator->randomInteger(50, 100);
        $this->assertIsInt($output, 'randomInteger did not generate an integer value : ' . $output);

        // above the bottom bound
        $this->assertTrue($output > 49, 'randomInteger did not match the bounds : ' . $output);

        // below the top bound
        $this->assertTrue($output < 101, 'randomInteger did not match the bounds : ' . $output);

        // edge case
        $output = $generator->randomInteger(50, 50);
        $this->assertEquals(50, $output, 'randomInteger did not match the bounds : ' . $output);

        // exception
        $this->expectException(GeneratorException::class);
        $generator->randomInteger(100, 50);
    }

    /**
     * Tests Generator::randomIntegerArray()
     *
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomIntegerArray()
    {
        $generator = new Generator();

        // test structure
        $output = $generator->randomIntegerArray();
        $this->assertIsArray(
            $output,
            'randomIntegerArray did not generate an array'
        );

        foreach ($output as $should_be_int) {
            $this->assertIsInt(
                $should_be_int,
                'randomIntegerArray did not generate an integer value : ' . $should_be_int
            );
        }

        // test size
        $output = $generator->randomIntegerArray(50, 100, 5);
        $this->assertCount(
            5,
            $output,
            'randomIntegerArray did not generate the correct array size : ' . count($output)
        );

        // test size
        $output = $generator->randomIntegerArray(50, 100, 0);
        $this->assertCount(
            0,
            $output,
            'randomIntegerArray did not generate the correct array size : ' . count($output)
        );

        // test exception
        $this->expectException(GeneratorException::class);
        $generator->randomIntegerArray(100, 50, 3);
    }

    /**
     * Tests Generator::randomJson()
     *
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomJson()
    {
        $generator = new Generator();

        // test arrays
        $output = $generator->randomJson(5, 0, 0, 0, 0);
        $this->assertIsString(
            $output,
            'randomJson did not produce a string : ' . $output
        );

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            5,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );

        foreach ($json_decoded as $should_be_array) {
            $this->assertIsArray(
                $should_be_array,
                'randomJson did not produce a set of arrays : ' . $output
            );
        }

        // test booleans
        $output = $generator->randomJson(0, 5, 0, 0, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            5,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );

        foreach ($json_decoded as $should_be_boolean) {
            $this->assertIsBool(
                $should_be_boolean,
                'randomBoolean did not generate a boolean value : ' . $output
            );
        }

        // test floats
        $output = $generator->randomJson(0, 0, 5, 0, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            5,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );

        foreach ($json_decoded as $should_be_float) {
            // as it's gone through the process of being made into json, the type info is lost, so 50 float is now 50 int:
            $cast_float = (float)$should_be_float;
            $this->assertIsFloat(
                $cast_float,
                'randomJson did not produce a set of floats : ' . $output
            );
            // check that they're equivalent
            $this->assertEquals(
                $cast_float,
                $should_be_float,
                'randomJson did not produce a set of floats : ' . $output
            );
        }

        // test integers
        $output = $generator->randomJson(0, 0, 0, 5, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            5,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );

        foreach ($json_decoded as $should_be_integer) {
            $this->assertIsInt(
                $should_be_integer,
                'randomJson did not produce a set of integers : ' . $output
            );
        }

        // test strings
        $output = $generator->randomJson(0, 0, 0, 0, 5);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            5,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );

        foreach ($json_decoded as $should_be_string) {
            $this->assertIsString(
                $should_be_string,
                'randomJson did not produce a set of strings : ' . $output
            );
        }

        // Mixed tests
        $output = $generator->randomJson();
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            15,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );


        // test full
        $output = $generator->randomJson(5, 5, 5, 5, 5);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            25,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );

        // test empty
        $output = $generator->randomJson(0, 0, 0, 0, 0);
        $this->assertIsString($output);

        $json_decoded = json_decode($output, true);
        $this->assertIsArray($json_decoded);
        $this->assertCount(
            0,
            $json_decoded,
            'randomJson did not generate the correct amount of elements   : ' . $output
        );
    }

    /**
     * Tests Generator::randomMySqlDate()
     *
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomMySqlDate()
    {
        $generator = new Generator();
        $date = $generator->randomMySqlDate();

        // test it is a valid time:
        $this->assertIsInt(
            strtotime($date),
            'randomMySqlDate did not generate a valid date : ' . $date
        );
    }

    /**
     * Tests Generator::randomMySqlDateTimeTimestamp()
     *
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomMySqlDateTimeTimestamp()
    {
        $generator = new Generator();
        $output = $generator->randomMySqlDateTimeTimestamp();

        // test it is a valid time:
        $this->assertIsInt(
            $output,
            'randomMySqlDateTimeTimestamp did not generate a valid date integer : ' . $output
        );

        // above the bottom MySql bound
        $this->assertTrue(
            $output >= -30610223999,
            'randomMySqlDateTimeTimestamp generated an integer that was out of bounds: ' . $output
        );

        // below the top MySql bound
        $this->assertTrue(
            $output <= 253402300799,
            'randomMySqlDateTimeTimestamp generated an integer that was out of bounds: ' . $output
        );
    }

    /**
     * Tests Generator::randomString()
     * @see Generator
     */
    public function testRandomString()
    {
        $generator = new Generator();

        $string = $generator->randomString();

        // test for string
        $this->assertIsString(
            $generator->randomString(),
            'randomString did not generate a valid string : ' . $string
        );

        // test length
        $length = 5;
        $string = $generator->randomString($length);
        $this->assertSame(
            $length,
            strlen($string),
            'randomString did not generate a string with the valid length : ' . $string
        );

        // test 0
        $length = 0;
        $string = $generator->randomString($length);
        $this->assertSame(
            $length,
            strlen($string),
            'randomString did not generate a string with the valid length : ' . $string
        );

        // test long length
        $length = 25;
        $string = $generator->randomString($length);
        $this->assertSame(
            $length,
            strlen($string),
            'randomString did not generate a string with the valid length : ' . $string
        );
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
        $this->assertIsArray($output, 'randomStringArray did not generate an array');

        foreach ($output as $should_be_string) {
            $this->assertIsString(
                $should_be_string,
                'randomStringArray did not generate a valid string : ' . $should_be_string
            );
        }

        // test size
        $output = $generator->randomStringArray(5, 10);
        $this->assertCount(
            10,
            $output,
            'randomStringArray did not generate the correct array size : ' . count($output)
        );

        // test empty
        $output = $generator->randomStringArray(5, 0);
        $this->assertCount(
            0,
            $output,
            'randomStringArray did not generate the correct array size : ' . count($output)
        );
    }

    // Aliases

    /**
     * Tests Generator::randomCurrency()
     *
     * @throws GeneratorException
     * @see Generator
     */
    public function testRandomCurrency()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomCurrency();
        $this->assertIsFloat(
            $output,
            'randomCurrency did not generate a float value : ' . $output
        );

        // above the bottom default bound
        $this->assertTrue(
            $output > 4,
            'randomCurrency did not match the bounds : ' . $output
        );

        // below the top bound
        $this->assertTrue(
            $output < 1001,
            'randomCurrency did not match the bounds : ' . $output
        );

        // decimal places
        $expected_decimal_places = 2;

        if ((int)$output == $output) {
            $decimal_places = 0;
        } else {
            $decimal_places = strlen($output) - strrpos($output, '.') - 1;
        }

        $this->assertTrue(
            $decimal_places <= $expected_decimal_places,
            'randomCurrency did not generate the correct decimal places: ' . $decimal_places . ', ' . $expected_decimal_places
        );

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
        $this->assertIsString(
            $output,
            'randomImageSrc did not generate a valid string : ' . $output
        );

        // check length
        $this->assertEquals(
            12,
            strlen($output),
            'randomImageSrc did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.png',
            substr($output, -4),
            'randomImageSrc did not generate a valid .png string suffix : ' . $output
        );

        // bounds and changes
        $output = $generator->randomImageSrc('.jpg', 7);

        // check length
        $this->assertEquals(
            11,
            strlen($output),
            'randomImageSrc did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.jpg',
            substr($output, -4),
            'randomImageSrc did not generate a valid .jpg string suffix : ' . $output
        );
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
        $this->assertIsString(
            $output,
            'randomImageUrl did not generate a valid string : ' . $output
        );

        // check length
        $this->assertEquals(
            36,
            strlen($output),
            'randomImageUrl did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.png',
            substr($output, -4),
            'randomImageUrl did not generate a valid .png string suffix : ' . $output
        );

        // bounds and changes
        $output = $generator->randomImageUrl('.jpg', 7, '.com', 4, false);

        // check length
        $this->assertEquals(
            20,
            strlen($output),
            'randomImageUrl did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.jpg',
            substr($output, -4),
            'randomImageUrl did not generate a valid .jpg string suffix : ' . $output
        );

        // check lowercase
        $this->assertFalse(
            preg_match("/[A-Z0-9]/", $output) === 0,
            'randomImageUrl did not generate a lowercase value : ' . $output
        );
    }

    /**
     * Tests Generator::randomMySqlDateTime()
     *
     * @throws GeneratorException
     */
    public function testRandomMySqlDateTime()
    {
        $generator = new Generator();
        $datetime = $generator->randomMySqlDateTime();

        // test it is a valid time:
        $this->assertIsInt(
            strtotime($datetime),
            'randomMySqlDateTime did not generate a valid date : ' . $datetime
        );
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
        $this->assertIsString(
            $output,
            'randomRandomUrl did not generate a valid string : ' . $output
        );

        // check length
        $this->assertEquals(
            23,
            strlen($output),
            'randomRandomUrl did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.com',
            substr($output, -4),
            'randomRandomUrl did not generate a valid .com string suffix : ' . $output
        );

        // check prefix
        $this->assertEquals(
            'http://',
            substr($output, 0, 7),
            'randomRandomUrl did not generate a valid http:// string prefix : ' . $output
        );

        // bounds and changes
        $output = $generator->randomUrl('.org', 7, false);

        // check length
        $this->assertEquals(
            11,
            strlen($output),
            'randomRandomUrl did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.org',
            substr($output, -4),
            'randomRandomUrl did not generate a valid .org string suffix : ' . $output
        );

        // check lowercase
        $this->assertFalse(
            preg_match("/[A-Z]/", $output) === 1,
            'randomRandomUrl did not generate a lowercase only value : ' . $output
        );
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
        $this->assertIsString(
            $output,
            'randomEmail did not generate a valid string : ' . $output
        );

        // check length
        $this->assertEquals(
            23,
            strlen($output),
            'randomEmail did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.com',
            substr($output, -4),
            'randomEmail did not generate a valid .com string suffix : ' . $output
        );

        // check includes @
        $this->assertStringContainsString(
            '@',
            $output,
            'randomEmail did not include an @ symbol : ' . $output
        );

        // bounds and changes
        $output = $generator->randomEmail('.org', 5, 5);

        // check length
        $this->assertEquals(
            15,
            strlen($output),
            'randomEmail did not generate a valid string length : ' . $output
        );

        // check suffix
        $this->assertEquals(
            '.org',
            substr($output, -4),
            'randomEmail did not generate a valid .org string suffix : ' . $output
        );

        // check lowercase
        $this->assertFalse(
            preg_match("/[A-Z0-9]/", $output) === 0,
            'randomEmail did not generate a lowercase value : ' . $output
        );
    }

    /**
     * Tests Generator::randomPassword()
     *
     * @see Generator
     */
    public function testRandomPassword()
    {
        $generator = new Generator();

        // no bounds
        $output = $generator->randomPassword();
        $this->assertIsString(
            $output,
            'randomPassword did not generate a valid string : ' . $output
        );

        // check length
        $this->assertEquals(
            16,
            strlen($output),
            'randomPassword did not generate a valid string length : ' . $output
        );

        // check contents
        $this->assertEquals(
            1,
            preg_match('/[A-Z]/', $output),
            'randomPassword did not include a capital letter : ' . $output
        );

        $this->assertEquals(
            1,
            preg_match('/[a-z]/', $output),
            'randomPassword did not include a lower case letter : ' . $output
        );

        $this->assertEquals(
            1,
            preg_match('/[0-9]/', $output),
            'randomPassword did not include a number : ' . $output
        );

        $this->assertEquals(
            1,
            // note: https://regex101.com/ is a godsend
            preg_match('/[!"#$%&()*+,-.\/:;<=>?@[\\]^_`{|}~]/', $output),
            'randomPassword did not include a symbol : ' . $output
        );

        // Exception
        $this->expectException(GeneratorException::class);
        $generator->randomFloat($generator->randomPassword(5));
    }

}

