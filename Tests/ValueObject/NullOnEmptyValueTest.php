<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\NullOnEmptyValue;

class NullOnEmptyValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseAValue()
    {
        new NullOnEmptyValue('some-value');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldWorkStatically()
    {
        $this->assertEquals('some-value', NullOnEmptyValue::create('some-value'));
        $this->assertNull(NullOnEmptyValue::create(' ')->getValue());
        $this->assertNull(NullOnEmptyValue::create('')->getValue());
        $this->assertNull(NullOnEmptyValue::create()->getValue());
        $this->assertNull(NullOnEmptyValue::create(null)->getValue());
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAValue
     */
    public function itShouldBeCastableToString()
    {
        $data  = 'some-value';
        $value = new NullOnEmptyValue($data);
        $this->assertEquals($data, (string)$value, 'The value could not be casted to string');
    }

    /**
     * @test
     * @depends itShouldParseAValue
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherNullOnEmptyValueObject()
    {
        $data = 'some-value';
        $v    = new NullOnEmptyValue(new NullOnEmptyValue($data));
        $this->assertEquals($data, (string)$v);
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseAValue
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new NullOnEmptyValue('some-value');
        $v2 = new NullOnEmptyValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }

    /**
     * @test
     * @group        ValueObject
     * @group        NullOnEmptyValue
     *
     * @param NullOnEmptyValue $testObject
     * @param NullOnEmptyValue $compare
     * @param boolean          $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(NullOnEmptyValue $testObject, NullOnEmptyValue $compare, $equals)
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
            array(new NullOnEmptyValue(''), new NullOnEmptyValue(null), true),
            array(new NullOnEmptyValue(''), new NullOnEmptyValue(), true),
            array(new NullOnEmptyValue(' '), new NullOnEmptyValue(), true),
            array(new NullOnEmptyValue(null), new NullOnEmptyValue(), true),
            array(new NullOnEmptyValue('some-value'), new NullOnEmptyValue('some-value'), true),
            array(new NullOnEmptyValue('some-values'), new NullOnEmptyValue('some-value'), false),
            array(new NullOnEmptyValue(), new NullOnEmptyValue('some-value'), false)
        );
    }
}


