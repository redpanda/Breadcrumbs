<?php

namespace Breadcrumb\Tests;

use Breadcrumbs\Trail;
use Breadcrumbs\Crumb;

class TrailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Breadcrumb\Trail::count
     */
    public function testCrumbs()
    {
        $trail = new Trail();
        $crumb1 = new Crumb('homepage', '/');
        $crumb2 = new Crumb('foo', '/foo');

        $this->assertEquals(0, count($trail));

        $trail->add($crumb1);
        $this->assertEquals(1, count($trail));

        $trail->add($crumb2);
        $this->assertEquals(2, count($trail));

        $expected = array($crumb1, $crumb2);
        $this->assertEquals($expected, $trail->getCrumbs());
    }

    public function testAdd()
    {
        $trail = new Trail();
        $crumb0 = new Crumb('homepage', '/');
        $crumb1 = new Crumb('foo', '/foo');

        $trail->add($crumb0);
        $this->assertEquals($trail, $crumb0->getTrail());

        $trail[] = $crumb1;
        $this->assertEquals($trail, $crumb1->getTrail());
    }

    public function testGet()
    {
        $trail = new Trail();
        $crumb0 = new Crumb('homepage', '/');
        $crumb1 = new Crumb('foo', '/v');

        $trail->add($crumb0);
        $this->assertEquals($crumb0, $trail->get(0));

        $trail[] = $crumb1;
        $this->assertEquals($crumb1, $trail[1]);
    }

    public function testHas()
    {
        $trail = new Trail();
        $crumb0 = new Crumb('homepage', '/');
        $trail->add($crumb0);
        $this->assertTrue($trail->has(0));

        $crumb1 = new Crumb('foo', '/foo');
        $trail[] = $crumb1;
        $this->assertTrue(isset($trail[1]));
    }

    public function testRemove()
    {
        $trail = new Trail();
        $crumb0 = new Crumb('homepage', '/');
        $crumb1 = new Crumb('foo', '/foo');
        $crumb2 = new Crumb('bar', '/bar');

        $trail[] = $crumb0;
        $trail[] = $crumb1;
        $trail[] = $crumb2;

        $this->assertEquals(3, count($trail));
        $trail->remove(2);
        $this->assertEquals(2, count($trail));
        unset($trail[1]);
        $this->assertEquals(1, count($trail));
        $this->assertEquals($crumb0, $trail[0]);
    }
}
