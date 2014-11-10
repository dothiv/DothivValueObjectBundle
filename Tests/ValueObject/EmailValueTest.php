<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\EmailValue;

class EmailValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseAnEmail()
    {
        new EmailValue('m@click4life.hiv');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAnEmail
     * @expectedException \Dothiv\ValueObject\Exception\InvalidArgumentException
     */
    public function itShouldNotParseAnInvalidEmail()
    {
        new EmailValue('bogus');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAnEmail
     */
    public function itShouldBeCastableToString()
    {
        $data  = 'm@click4life.hiv';
        $value = new EmailValue($data);
        $this->assertEquals((string)$value, $data, 'The value could not be casted to string');
    }

    /**
     * @test
     * @depends itShouldParseAnEmail
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherUrlValueObject()
    {
        $data = 'm@click4life.hiv';
        $v    = new EmailValue(new EmailValue($data));
        $this->assertEquals((string)$v, $data);
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseAnEmail
     */
    public function itShouldParseItsScalarValue()
    {
        $email  = new EmailValue('m@click4life.hiv');
        $email2 = new EmailValue($email->toScalar());
        $this->assertEquals($email->__toString(), $email2->__toString());
    }

    /**
     * @test
     * @depends itShouldParseAnEmail
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldReturnParts()
    {
        $value = new EmailValue('m+extension@click4life.hiv');
        $this->assertEquals('m', $value->getUser());
        $this->assertEquals('click4life.hiv', $value->getHostname());
        $this->assertEquals('extension', $value->getExtension());
    }

    /**
     * @test
     * @group        ValueObject
     * @group        EmailValue
     *
     * @param EmailValue $testObject
     * @param EmailValue $compare
     * @param boolean    $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(EmailValue $testObject, EmailValue $compare, $equals)
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
            array(new EmailValue('m+extension@click4life.hiv'), new EmailValue('m+extension@click4life.hiv'), true),
            array(new EmailValue('m+extension@click4life.hiv'), new EmailValue('m@click4life.hiv'), false)
        );
    }
}


