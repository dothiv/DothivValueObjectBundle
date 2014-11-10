<?php

namespace Dothiv\ValueObject\Tests\Service;

use Dothiv\ValueObject\ClockValue;

class ClockValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group ValueObject
     * @group Service
     * @group Clock
     */
    public function itShouldBeInstantiateable()
    {
        $clock = $this->getTestObject();
        $this->assertInstanceOf('\Dothiv\ValueObject\ClockValue', $clock);
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @group   ClockValue
     * @depends itShouldBeInstantiateable
     */
    public function itShouldReturnADate()
    {
        $clock = $this->getTestObject();
        $this->assertInstanceOf('\DateTime', $clock->getNow());
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @group   ClockValue
     * @depends itShouldReturnADate
     */
    public function itShouldReturnASpecificDate()
    {
        $testClock = new \DateTime();
        $testClock->modify('+2 years');
        $clock = $this->getTestObject($testClock);
        $this->assertEquals($testClock, $clock->getNow());
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @group   ClockValue
     * @depends itShouldBeInstantiateable
     */
    public function itShouldBeImmutable()
    {
        $clock = $this->getTestObject();
        $now1  = $clock->getNow();
        $now1->modify('+1 year');
        $now2 = $clock->getNow();
        $this->assertNotEquals($now1->getTimestamp(), $now2->getTimestamp());
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @group   ClockValue
     * @depends itShouldBeInstantiateable
     */
    public function itShouldParseItsScalarValue()
    {
        $clock  = $this->getTestObject();
        $clock2 = new ClockValue($this->getTestObject()->toScalar());
        $this->assertEquals($clock->getNow()->getTimestamp(), $clock2->getNow()->getTimestamp());
    }

    /**
     * @param \DateTime $date
     *
     * @return ClockValue
     */
    protected function getTestObject(\DateTime $date = null)
    {
        return new ClockValue($date);
    }

    /**
     * @test
     * @group        ValueObject
     * @group        ClockValue
     *
     * @param ClockValue $testObject
     * @param ClockValue $compare
     * @param boolean    $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(ClockValue $testObject, ClockValue $compare, $equals)
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
            array($this->getTestObject(new \DateTime('1970-01-01T00:00:00Z')), $this->getTestObject(new \DateTime('1970-01-01T00:00:00Z')), true),
            array($this->getTestObject(new \DateTime('1971-01-01T00:00:00Z')), $this->getTestObject(new \DateTime('1970-01-01T00:00:00Z')), false)
        );
    }
}
