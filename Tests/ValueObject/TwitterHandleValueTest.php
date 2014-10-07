<?php

namespace Dothiv\BusinessBundle\Tests\Entity\ValueObject;

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
}