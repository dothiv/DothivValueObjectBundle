<?php

namespace Dothiv\ValueObject\Tests\Service;

use Dothiv\ValueObject\ClockValue;

class ClockTest extends \PHPUnit_Framework_TestCase
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
     * @group   Clock
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
     * @group   Clock
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
     * @group   Clock
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
     * @group   Clock
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
} 
