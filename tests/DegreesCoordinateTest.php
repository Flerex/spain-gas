<?php

namespace Flerex\SpainGas\Tests;

use Flerex\SpainGas\Dtos\DegreesCoordinate;
use PHPUnit\Framework\TestCase;

final class DegreesCoordinateTest extends TestCase
{

    private const TEST_DECIMAL = 156.742;

    /** @test
     * The class must correctly convert decimal to degrees.
     */
    public function converts_decimal_to_degrees()
    {
        $degrees = new DegreesCoordinate(self::TEST_DECIMAL, 'N', 'S');

        $this->assertEquals(156, $degrees->degrees);
        $this->assertEquals(44, $degrees->minutes);
        $this->assertEquals(31, $degrees->seconds);
        $this->assertEquals('N', $degrees->descriptor);

        $degrees = new DegreesCoordinate(-self::TEST_DECIMAL, 'N', 'S');

        $this->assertEquals(156, $degrees->degrees);
        $this->assertEquals(44, $degrees->minutes);
        $this->assertEquals(31, $degrees->seconds);
        $this->assertEquals('S', $degrees->descriptor);
    }

    /** @test
     * This class should be able to return a string with the common degree format.
     */
    public function can_normalize_to_string()
    {
        $degrees = new DegreesCoordinate(self::TEST_DECIMAL, 'N', 'S');

        $this->assertEquals('156º 44\' 31" N', $degrees->normalize());

        $degrees = new DegreesCoordinate(-self::TEST_DECIMAL, 'N', 'S');

        $this->assertEquals('156º 44\' 31" S', $degrees->normalize());
    }

    /** @test
     * This class should be able to be cast as a string, returning the normalized degree format.
     */
    public function can_be_cast_to_string()
    {
        $degrees = new DegreesCoordinate(self::TEST_DECIMAL, 'E', 'W');

        $this->assertEquals('156º 44\' 31" E', (string) $degrees);
    }



}
