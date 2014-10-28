<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\HexValue;

class HexValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseAHexValue()
    {
        new HexValue('#336699');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAHexValue
     * @expectedException \Dothiv\ValueObject\Exception\InvalidArgumentException
     */
    public function itShouldNotParseAnInvalidHexValue()
    {
        new HexValue('bogus');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAHexValue
     */
    public function itShouldBeCastableToString()
    {
        $data  = '#336699';
        $value = new HexValue($data);
        $this->assertEquals($data, (string)$value, 'The value could not be casted to string');
    }

    /**
     * @test
     * @depends itShouldParseAHexValue
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherHexValueObject()
    {
        $data = '#336699';
        $v    = new HexValue(new HexValue($data));
        $this->assertEquals($data, (string)$v);
    }

    /**
     * @test
     * @depends itShouldParseAHexValue
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldExpandShortHexValues()
    {
        $data = '#af9';
        $v    = new HexValue($data);
        $this->assertEquals('#AAFF99', (string)$v);
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseAHexValue
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new HexValue('#AAFF99');
        $v2 = new HexValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }
}


