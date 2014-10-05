<?php

namespace Dothiv\BusinessBundle\Tests\Entity\ValueObject;

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
}


