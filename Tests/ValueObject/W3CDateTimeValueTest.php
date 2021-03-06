<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\W3CDateTimeValue;

class W3CDateTimeValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseADate()
    {
        new W3CDateTimeValue('2014-08-12T19:18:17Z');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseADate
     * @expectedException \Dothiv\ValueObject\Exception\InvalidArgumentException
     */
    public function itShouldNotParseAnInvalidDate()
    {
        new W3CDateTimeValue('bogus');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseADate
     */
    public function itShouldBeCastableToString()
    {
        $data  = '2014-06-21T00:00:00+00:00';
        $value = new W3CDateTimeValue($data);
        $this->assertEquals($data, (string)$value, 'The value could not be casted to string');
    }

    /**
     * @test
     * @depends itShouldParseADate
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherValueObject()
    {
        $data = '2014-06-21T00:00:00+00:00';
        $v    = new W3CDateTimeValue(new W3CDateTimeValue($data));
        $this->assertEquals($data, (string)$v);
    }

    /**
     * @test
     * @group        unit
     * @group        ValueObject
     * @depends      itShouldParseADate
     * @dataProvider provideTestDates
     */
    public function itShouldParseDifferentFormats($expected, $arg)
    {
        $v = new W3CDateTimeValue($arg);
        $this->assertEquals($expected, (string)$v);
    }

    /**
     * @test
     * @group        unit
     * @group        ValueObject
     * @depends      itShouldParseADate
     * @dataProvider provideTestDates
     */
    public function itShouldWorkStatically($expected, $arg)
    {
        $v = W3CDateTimeValue::create($arg);
        $this->assertInstanceOf('\Dothiv\ValueObject\W3CDateTimeValue', $v);
        $this->assertEquals($expected, (string)$v);
    }

    /**
     * @return array
     */
    public function provideTestDates()
    {
        return array(
            array('2014-06-21T00:00:00+00:00', new \DateTime('2014-06-21T00:00:00Z')),
            array('2014-06-21T00:00:00+00:00', '2014-06-21T00:00:00Z'),
        );
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseADate
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new W3CDateTimeValue('2014-06-21T00:00:00+00:00');
        $v2 = new W3CDateTimeValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }

    /**
     * @test
     * @group        ValueObject
     * @group        W3CDateTimeValue
     *
     * @param W3CDateTimeValue $testObject
     * @param W3CDateTimeValue $compare
     * @param boolean          $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(W3CDateTimeValue $testObject, W3CDateTimeValue $compare, $equals)
    {
        $this->assertEquals($equals, $testObject->equals($compare));
    }

    /**
     * Test data provider for itShouldCompare
     *
     * @return array
     */
    public function itShouldCompareDataProvider()
    {
        return array(
            array(new W3CDateTimeValue('2014-06-21T00:00:00+00:00'), new W3CDateTimeValue('2014-06-21T00:00:00+00:00'), true),
            array(new W3CDateTimeValue('2014-06-20T00:00:00+00:00'), new W3CDateTimeValue('2014-06-21T00:00:00+00:00'), false)
        );
    }
}


