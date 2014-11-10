<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\IdentValue;

class IdentValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseAIdentValue()
    {
        new IdentValue('some-ident');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAIdentValue
     * @expectedException \Dothiv\ValueObject\Exception\InvalidArgumentException
     */
    public function itShouldNotParseAnInvalidIdentValue()
    {
        new IdentValue('not an ident');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAIdentValue
     */
    public function itShouldBeCastableToString()
    {
        $data  = 'some-ident';
        $value = new IdentValue($data);
        $this->assertEquals($data, (string)$value, 'The value could not be casted to string');
    }

    /**
     * @test
     * @depends itShouldParseAIdentValue
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherIdentValueObject()
    {
        $data = 'some-ident';
        $v    = new IdentValue(new IdentValue($data));
        $this->assertEquals($data, (string)$v);
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseAIdentValue
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new IdentValue('some-ident');
        $v2 = new IdentValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }

    /**
     * @test
     * @group        ValueObject
     * @group        IdentValue
     *
     * @param IdentValue $testObject
     * @param IdentValue $compare
     * @param boolean        $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(IdentValue $testObject, IdentValue $compare, $equals)
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
            array(new IdentValue('some-ident'), new IdentValue('some-ident'), true),
            array(new IdentValue('some-idents'), new IdentValue('some-ident'), false)
        );
    }
}


