<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\Exception\InvalidArgumentException;
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

    /**
     * @test
     * @group        ValueObject
     * @group        HivDomainValue
     *
     * @param HivDomainValue $testObject
     * @param HivDomainValue $compare
     * @param boolean        $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(HivDomainValue $testObject, HivDomainValue $compare, $equals)
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
            array(new HivDomainValue('example.hiv'), new HivDomainValue('example.hiv'), true),
            array(new HivDomainValue('examples.hiv'), new HivDomainValue('example.hiv'), false)
        );
    }

    /**
     * @test
     * @group        ValueObject
     * @group        HivDomainValue
     *
     * @param string  $domain
     * @param boolean $valid
     *
     * @dataProvider idnDomainProvider
     */
    public function itShouldCheckIDNCharacters($domain, $valid)
    {
        try {
            new HivDomainValue($domain);
            if (!$valid) {
                $this->fail("This domain should not be valid: " . $domain);
            }
        } catch (InvalidArgumentException $e) {
            if ($valid) {
                $this->fail("This domain should be valid: " . $domain);
            }
        }
    }

    /**
     * @return array
     */
    public function idnDomainProvider()
    {
        return array(
            array("xn--mgb9awbf6b.hiv", false), // عُمان (oman)
            array("xn--pdam11a.hiv", true), // øþš.hiv
            array('xn--brger-kva.hiv', true), // bürger.hiv
        );
    }
}


