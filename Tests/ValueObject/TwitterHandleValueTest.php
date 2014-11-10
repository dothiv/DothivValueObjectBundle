<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\TwitterHandleValue;

class TwitterHandleValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldParseATwitterhandle()
    {
        new TwitterHandleValue('@tldhiv');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseATwitterhandle
     * @expectedException \Dothiv\ValueObject\Exception\InvalidArgumentException
     */
    public function itShouldNotParseAnInvalidTwitterhandle()
    {
        new TwitterHandleValue('bogus');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseATwitterhandle
     */
    public function itShouldBeCastableToString()
    {
        $data  = '@tldhiv';
        $value = new TwitterHandleValue($data);
        $this->assertEquals((string)$value, $data, 'The value could not be casted to string');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseATwitterhandle
     */
    public function itShouldKeepCase()
    {
        $data  = '@tldHIV';
        $value = new TwitterHandleValue($data);
        $this->assertEquals((string)$value, $data);
    }

    /**
     * @test
     * @depends itShouldParseATwitterhandle
     * @group   unit
     * @group   ValueObject
     */
    public function itShouldNotContainAnotherValueObject()
    {
        $data = '@tldhiv';
        $v    = new TwitterHandleValue(new TwitterHandleValue($data));
        $this->assertEquals((string)$v, $data);
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseATwitterhandle
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new TwitterHandleValue('@tldhiv');
        $v2 = new TwitterHandleValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }

    /**
     * @test
     * @group        ValueObject
     * @group        TwitterHandleValue
     *
     * @param TwitterHandleValue $testObject
     * @param TwitterHandleValue $compare
     * @param boolean            $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(TwitterHandleValue $testObject, TwitterHandleValue $compare, $equals)
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
            array(new TwitterHandleValue('@tldhiv'), new TwitterHandleValue('@tldhiv'), true),
            array(new TwitterHandleValue('@hivtld'), new TwitterHandleValue('@tldhiv'), false)
        );
    }
}
