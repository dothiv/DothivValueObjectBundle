<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\HivDomainValue;

class HivDomainValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseADomain()
    {
        new HivDomainValue('click4life.hiv');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseADomain
     * @expectedException \Dothiv\ValueObject\Exception\InvalidArgumentException
     */
    public function itShouldNotParseAnInvalidDomain()
    {
        new HivDomainValue('bogus');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseADomain
     */
    public function itShouldBeCastableToString()
    {
        $data  = 'click4life.hiv';
        $value = new HivDomainValue($data);
        $this->assertEquals((string)$value, $data, 'The value could not be casted to string');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseADomain
     */
    public function itShouldBeLowerCase()
    {
        $data  = 'Click4Life.HIV';
        $value = new HivDomainValue($data);
        $this->assertEquals((string)$value, strtolower($data));
    }

    /**
     * @test
     * @depends itShouldParseADomain
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherValueObject()
    {
        $data = 'click4life.hiv';
        $v    = new HivDomainValue(new HivDomainValue($data));
        $this->assertEquals((string)$v, $data);
    }

    /**
     * @test
     * @depends itShouldParseADomain
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldReturnParts()
    {
        $value = new HivDomainValue('click4life.hiv');
        $this->assertEquals('click4life', $value->getSecondLevel());
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseADomain
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new HivDomainValue('click4life.hiv');
        $v2 = new HivDomainValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }

    /**
     * @test
     * @depends      itShouldParseADomain
     * @group        unit
     * @group        ValueObject
     * @dataProvider provideIdnConversionData
     */
    public function itShouldConvertIdnToUTF8($idn, $utf8)
    {
        $domain = new HivDomainValue($idn);
        $this->assertEquals($utf8, $domain->toUTF8());
    }

    /**
     * @test
     * @depends      itShouldParseADomain
     * @group        unit
     * @group        ValueObject
     * @dataProvider provideIdnConversionData
     */
    public function itShouldConvertUTF8toIDN($idn, $utf8)
    {
        $domain = HivDomainValue::createFromUTF8($utf8);
        $this->assertEquals($idn, (string)$domain);
    }

    public function provideIdnConversionData()
    {
        return array(
            array('example.hiv', 'example.hiv'),
            array('xn--brger-kva.hiv', 'bürger.hiv')
        );
    }
}


