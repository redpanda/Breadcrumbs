<?php

namespace Breadcrumbs\Tests;

use Breadcrumbs\Trail;
use Breadcrumbs\Crumb;

class CrumbTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $crumb = new Crumb('foo', '/');
        $this->assertEquals('foo', $crumb->getTitle());
        $crumb->setTitle('Foo');
        $this->assertEquals('Foo', $crumb->getTitle());      
    }

    public function testUri()    
    {
        $crumb = new Crumb('foo');
        $this->assertFalse($crumb->hasUri());
        $crumb->setUri('/foo');
        $this->assertEquals('/foo', $crumb->getUri());
    }

    public function testAttributes()
    {
        $crumb = new Crumb('foo', null, array(
            'class' => 'bar'
        ));
        $this->assertEquals(array('class' => 'bar'), $crumb->getAttributes());

        $crumb->addAttribute('id', 'foo');
        $this->assertEquals(array('class' => 'bar', 'id' => 'foo'), $crumb->getAttributes());
    }

    public function testIsFirst()
    {
        $crumb = new Crumb('foo');
        $trail = new Trail();
        $this->assertFalse($crumb->isFirst());

        $trail->add($crumb);
        $this->assertTrue($crumb->isFirst());

        $crumb2 = new Crumb('bar');
        $trail->add($crumb2);
        $this->assertTrue($crumb->isFirst());
        $this->assertFalse($crumb2->isFirst());
    }

    public function testIsLast()
    {
        $crumb = new Crumb('foo');
        $trail = new Trail();
        $this->assertFalse($crumb->isLast());

        $trail->add($crumb);
        $this->assertTrue($crumb->isLast());

        $crumb2 = new Crumb('bar');
        $trail->add($crumb2);
        $this->assertFalse($crumb->isLast());
        $this->assertTrue($crumb2->isLast());
    }
}
