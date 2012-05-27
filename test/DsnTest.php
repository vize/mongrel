<?php

namespace Mongrel;

require_once dirname( __FILE__ ) . '/../Dsn.php';
require_once dirname( __FILE__ ) . '/../DsnException.php';

class DsnTest extends \PHPUnit_Framework_TestCase
{
    public function invalidDsnProvider()
    {
        return array(
            array( 'tcp://127.0.0.1:999999' ),
            array( 'test' )
        );
    }
    
    public function validDsnProvider()
    {
        return array(
            array( 'tcp://127.0.0.1:9996', array( 'tcp', '127.0.0.1', '9996' ) ),
            array( 'tcp://*:8000', array( 'tcp', '*', '8000' ) )
        );
    }
    
    /** @dataProvider invalidDsnProvider **/
    public function testConstructor_InvalidParams( $dsn )
    {
        $this->setExpectedException( 'Mongrel\DsnException' );
        
        $object = new Dsn( $dsn );
    }
    
    /** @dataProvider validDsnProvider **/
    public function testConstructor_ValidParams( $dsn, $expected )
    {
        $object = new Dsn( $dsn );
        
        $this->assertAttributeSame( $expected[0], 'protocol', $object );
        $this->assertAttributeSame( $expected[1], 'ip', $object );
        $this->assertAttributeSame( $expected[2], 'port', $object );
    }

    /** @dataProvider validDsnProvider **/
    public function testGetProtocol( $dsn, $expected )
    {
        $object = new Dsn( $dsn );
        
        $this->assertEquals( $expected[0], $object->getProtocol() );
    }

    /** @dataProvider validDsnProvider **/
    public function testGetIp( $dsn, $expected )
    {
        $object = new Dsn( $dsn );
        
        $this->assertEquals( $expected[1], $object->getIp() );
    }

    /** @dataProvider validDsnProvider **/
    public function testGetPort( $dsn, $expected )
    {
        $object = new Dsn( $dsn );
        
        $this->assertEquals( $expected[2], $object->getPort() );
    }
    
    /** @dataProvider validDsnProvider **/
    public function testToString( $dsn, $expected )
    {
        $object = new Dsn( $dsn );
        
        $this->assertEquals( $dsn, $object->toString() );
    }
}