<?php

namespace Ajgl\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\Tests\DBAL\Mocks\MockPlatform;

/**
 * Test class for InetType.
 * Generated by PHPUnit on 2012-07-18 at 09:03:09.
 */
class ArrayTypeAbstractTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockPlatform
     */
    protected $platform;

    /**
     * @var ArrayTypeAbstract
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        if (!Type::hasType('foo')) {
            Type::addType('foo', 'Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstractConcrete');
        } else {
            Type::overrideType('foo', 'Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstractConcrete');
        }
        $this->platform = new MockPlatform();
        $this->object = Type::getType('foo');
    }

    /**
     * @covers Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstract::getSqlDeclaration
     */
    public function testGetSqlDeclaration()
    {
        $this->assertEquals('DUMMYVARCHAR[]', $this->object->getSqlDeclaration(array(), $this->platform));
    }

    /**
     * @covers Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstract::getSqlDeclaration
     */
    public function testGetName()
    {
        $this->assertEquals('foo', $this->object->getName());
    }

    /**
     * @covers Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstract::canRequireSQLConversion
     */
    public function testCanRequireSQLConversion()
    {
        $this->assertTrue($this->object->canRequireSQLConversion());
    }

    /**
     * @covers Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstract::convertToDatabaseValue
     */
    public function testConvertToDatabaseValue()
    {
        $value = array(
            array(
                'uno',
                'dos'
            ),
            array(
                'tres',
                'cuatro'
            )
        );
        $expected = '{{uno,dos},{tres,cuatro}}';
        $actual = $this->object->convertToDatabaseValue($value, $this->platform);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstract::convertToPhpValue
     */
    public function testConvertToPhpValue()
    {
        $value = '{{uno,dos},{tres,cuatro}}';
        $expected = array(
            array(
                'uno',
                'dos'
            ),
            array(
                'tres',
                'cuatro'
            )
        );
        $actual = $this->object->convertToPhpValue($value, $this->platform);
        $this->assertEquals($expected, $actual);
    }


    public function testConvertToPhpNullValues()
    {
        $value = null;
        $actual = $this->object->convertToPhpValue($value, $this->platform);
        $this->assertNull($actual);

    }

    /**
     * @covers Ajgl\Doctrine\DBAL\Types\ArrayTypeAbstract::getInnerType
     */
    public function testGetInnerType()
    {
        $this->assertInstanceOf('Doctrine\DBAL\Types\StringType', $this->object->getInnerType());
    }
}

class ArrayTypeAbstractConcrete
    extends ArrayTypeAbstract
{
    /**
     * @var string
     */
    protected $name = 'foo';

    /**
     * @var string
     */
    protected $innerTypeName = 'string';

}
