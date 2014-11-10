<?php

namespace Dothiv\ValueObject\Tests\Entity\ValueObject;

use Dothiv\ValueObject\PathValue;

class PathValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @group   ValueObject
     * @group   unit
     */
    public function itShouldParseAPath()
    {
        new PathValue('/some/path/with/a/file.txt');
    }

    /**
     * @test
     * @group   ValueObject
     * @group   unit
     * @depends itShouldParseAPath
     */
    public function itShouldBeCastableToString()
    {
        $data = '/some/path/with/a/file.txt';
        $p    = new PathValue($data);
        $this->assertEquals($data, (string)$p, 'The value could not be casted to string');
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAPath
     */
    public function itShouldNotContainAnotherPathValueObject()
    {
        $data = '/some/path/with/a/file.txt';
        $p    = new PathValue(new PathValue($data));
        $this->assertEquals($data, $p->getPathname());
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAPath
     */
    public function itShouldAddANameSuffix()
    {
        $p = PathValue::create('/some/path/with/a/file.txt')->addFilenameSuffix('@suffix');
        $this->assertEquals('/some/path/with/a/file@suffix.txt', $p->getPathname());
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAPath
     */
    public function itShouldReturnTheFileInfoObject()
    {
        $p = PathValue::create('/some/path/with/a/file.txt')->addFilenameSuffix('@suffix');
        $this->assertEquals('/some/path/with/a/file@suffix.txt', $p->getFileInfo()->getPathname());
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAPath
     */
    public function itShouldSupportIsFile()
    {
        $p = PathValue::create(__FILE__);
        $this->assertTrue($p->isFile());
    }

    /**
     * @test
     * @group   unit
     * @group   ValueObject
     * @depends itShouldParseAPath
     */
    public function itShouldSupportIsDir()
    {
        $p = PathValue::create(__DIR__);
        $this->assertTrue($p->isDir());
    }

    /**
     * @test
     * @group   ValueObject
     * @group   Service
     * @depends itShouldParseAPath
     */
    public function itShouldParseItsScalarValue()
    {
        $v  = new PathValue('/some/path/with/a/file.txt');
        $v2 = new PathValue($v->toScalar());
        $this->assertEquals($v->__toString(), $v2->__toString());
    }

    /**
     * @test
     * @group        ValueObject
     * @group        PathValue
     *
     * @param PathValue $testObject
     * @param PathValue $compare
     * @param boolean   $equals
     *
     * @dataProvider itShouldCompareDataProvider
     */
    public function itShouldCompare(PathValue $testObject, PathValue $compare, $equals)
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
            array(new PathValue('/some/path/with/a/file.txt'), new PathValue('/some/path/with/a/file.txt'), true),
            array(new PathValue('/some/path/with/a/otherfile.txt'), new PathValue('/some/path/with/a/file.txt'), false)
        );
    }
}


