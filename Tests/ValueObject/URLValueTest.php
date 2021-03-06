<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\URLValue;

class URLValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseAnURL()
    {
        new URLValue('https://click4life.hiv/');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAnURL
     * @expectedException \Dothiv\ValueObject\Exception\InvalidArgumentException
     */
    public function itShouldNotParseAnInvalidURL()
    {
        new URLValue('bogus');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAnURL
     */
    public function itShouldBeCastableToString()
    {
        $data  = 'https://click4life.hiv/';
        $value = new URLValue($data);
        $this->assertEquals((string)$value, $data, 'The value could not be casted to string');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAnURL
     */
    public function urlsAlwaysShouldHaveATrailingSlash()
    {
        $d = new URLValue('https://click4life.hiv');
        $this->assertEquals('https://click4life.hiv/', (string)$d);
    }

    /**
     * @test
     * @depends itShouldParseAnURL
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherUrlValueObject()
    {
        $data = 'https://click4life.hiv/';
        $v    = new URLValue(new URLValue($data));
        $this->assertEquals((string)$v, $data);
    }

    /**
     * @test
     * @depends itShouldParseAnURL
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldReturnParts()
    {
        $value = new URLValue('https://www.example.com/directory/index.php?query=true#fragment');
        $this->assertEquals('https', $value->getScheme());
        $this->assertEquals('www.example.com', $value->getHostname());
        $this->assertEquals('/directory/index.php', $value->getPath());
        $this->assertEquals('query=true', $value->getQuery());
        $this->assertEquals('fragment', $value->getFragment());
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseAnURL
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new URLValue('https://www.example.com/directory/index.php?query=true#fragment');
        $v2 = new URLValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }

    /**
     * @test
     * @group        ValueObject
     * @group        URLValue
     *
     * @param URLValue $testObject
     * @param URLValue $compare
     * @param boolean  $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(URLValue $testObject, URLValue $compare, $equals)
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
            array(new URLValue('https://www.example.com/directory/'), new URLValue('https://www.example.com/directory/'), true),
            array(new URLValue('http://www.example.com/directory/'), new URLValue('https://www.example.com/directory/'), false)
        );
    }
}


